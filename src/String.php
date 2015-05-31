<?php

/*
 * The MIT License
 *
 * Copyright 2015 Samy NAAMANI.
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

namespace SNTools\Types;

/**
 * String wrapper class
 *
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 */
class String extends Type {
    protected function clear() {
        $this->value = '';
    }
    protected function fromString($value) {
        $this->value = $value;
        return true;
    }
    protected function fromArray(array $value) {
        return $this->fromString(serialize($value));
    }
    protected function fromBool($value) {
        return $this->fromString(strval($value));
    }
    protected function fromDouble($value) {
        return $this->fromString(strval($value));
    }
    protected function fromInt($value) {
        return $this->fromString(strval($value));
    }
    final public function __toString() {
        return $this->value;
    }
    /**
     * Checks if string is empty
     * @return boolean
     */
    final public function isEmpty() {
        return empty($this->value);
    }
    /**
     * Checks if string matches a regexp
     * @param string $regex Regexp to match the string with
     * @return boolean
     */
    final public function match($regex) {
        Regex::create($regex);
        return false !== $regex->match($this->value);
    }

    /**
     * Appends a string to this string
     * @param string $string String to add
     * @return self Result string
     */
    public function concat($string) {
        String::create($string);
        $result = null;
        static::create($result, $this->getValue() . $string->getValue());
        return $result;
    }
}
