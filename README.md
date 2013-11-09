# React/Partial

Partial function application.

[![Build Status](https://secure.travis-ci.org/reactphp/partial.png?branch=master)](http://travis-ci.org/reactphp/partial)

## Install

The recommended way to install react/partial is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "react/partial": "~2.0"
    }
}
```

## Concept

> Partial application (or partial function application) refers to the process
> of fixing a number of arguments to a function, producing another function of
> smaller arity. Given a function `f:(X x Y x Z) -> N`, we might fix (or
> 'bind') the first argument, producing a function of type `f:(Y x Z) -> N`.
> Evaluation of this function might be represented as `f partial(2, 3)`.
> Note that the result of partial function application in this case is a
> function that takes two arguments.

Basically, what this allows you to do is pre-fill arguments of a function,
which is particularly useful if you don't have control over the function
caller.

Let's say you have an async operation which takes a callback. How about a file
download. The callback is called with a single argument: The contents of the
file. Let's also say that you have a function that you want to be called once
that file download completes. This function however needs to know an
additional piece of information: the filename.

```php
<?php

public function handleDownload($filename)
{
    $this->downloadFile($filename, ...);
}

public function downloadFile($filename, $callback)
{
    $contents = get the darn file asynchronously...
    $callback($contents);
}

public function processDownloadResult($filename, $contents)
{
    echo "The file $filename contained a shitload of stuff:\n";
    echo $contents;
}
```

The conventional approach to this problem is to wrap everything in a closure
like so:

```php
<?php

public function handleDownload($filename)
{
    $this->downloadFile($filename, function ($contents) use ($filename) {
        $this->processDownloadResult($filename, $contents);
    });
}
```

This is not too bad, especially with PHP 5.4, but with 5.3 you need to do the
annoying `$that = $this` dance, and in general it's a lot of verbose
boilerplate that you don't really want to litter your code with.

This is where partial application can help. Since we want to pre-fill an
argument to the function that will be called, we just call `bind`, which will
insert it to the left of the arguments list. The return value of `bind` is a
new function which takes one `$content` argument.

```php
<?php

use React\Partial;

public function handleDownload($filename)
{
    $this->downloadFile($filename, Partial\bind([$this, 'processDownloadResult'], $filename));
}
```

This is way cleaner. Sure, it's still a bit ugly due to the weird `::` and
`[$this, ...]` and so on, but it already helps quite a lot.

Partialing is dependency injection for functions! How awesome is that?

## Examples

### bind

```php
<?php

use React\Partial;

$add = function ($a, $b) {
    return $a + $b;
};

$addOne = Partial\bind($add, 1);

echo sprintf("%s\n", $addOne(5));
// outputs 6
```

### placeholder

It is possible to use the `…` function (there is an alias called
`placeholder`) to skip some arguments when partially applying.

This allows you to pre-define arguments on the right, and have the left ones
bound at call time.

This example skips the first argument and sets the second and third arguments
to `0` and `1` respectively. The result is a function that returns the first
character of a string.

**Note:** Usually your IDE should help but accessing the "…"-character
(HORIZONTAL ELLIPSIS, U+2026) differs on various platforms.

 - Windows: `ALT + 0133`
 - Mac: `ALT + ;` or `ALT + .`
 - Linux: `AltGr + .`

```php
<?php

use React\Partial;

$firstChar = Partial\bind('substr', Partial\…(), 0, 1);
$mapped = array_map($firstChar, array('foo', 'bar', 'baz'));

var_dump($mapped);
// outputs ['f', 'b', 'b']
```

## Tests

To run the test suite, you need PHPUnit.

    $ phpunit

## License

MIT, see LICENSE.
