<?php
/**
 * Copyright (C) 2011-2013 by Lars Strojny <lstrojny@php.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Functional;

/**
 * Recombines arrays by index and applies a callback optionally
 *
 * @param \Traversable|array $collection One or more callbacks
 * @param callable $callback Optionally the last argument can be a callback
 * @return array
 */
function zip($collection)
{
    $args = func_get_args();

    $callback = null;
    if (is_callable(end($args))) {
        $callback = array_pop($args);
    }

    foreach ($args as $position => $collection) {
        Exceptions\InvalidArgumentException::assertCollection($collection, __FUNCTION__, $position + 1);
    }

    $result = array();
    foreach (func_get_arg(0) as $index => $value) {
        $zipped = array();

        foreach ($args as $arg) {
            $zipped[] = isset($arg[$index]) ? $arg[$index] : null;
        }

        if ($callback !== null) {
            $zipped = call_user_func_array($callback, $zipped);
        }

        $result[] = $zipped;
    }

    return $result;
}
