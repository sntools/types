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
 * Wrapper for numbers (floats and integers)
 * For integer-specific wrapper, see Int and UInt
 *
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 */
class Number extends Type implements Comparable {
    protected function fromDouble($value) {
        $this->value = $value;
        return true;
    }
    protected function fromInt($value) {
        return $this->fromDouble($value);
    }
    protected function fromBool($value) {
        return $this->fromDouble($value ? 1 : 0);
    }
    protected function fromString($value) {
        $temp = (double)$value;
        return ($temp == $value) ? $this->fromDouble($temp) : false;
    }
    /**
     * Adds a number to this number
     * @param self $b
     * @return self
     */
    public function add($b) {
        static::create($b);
        static::create($b, $this->value + $b->value);
        return $b;
    }
    /**
     * Deduces a number to this number
     * @param self $b
     * @return self
     */
    public function sub($b) {
        static::create($b);
        static::create($b, $this->value - $b->value);
        return $b;
    }
    /**
     * Multiplies a number by this number
     * @param self $b
     * @return self
     */
    public function times($b) {
        static::create($b);
        static::create($b, $this->value * $b->value);
        return $b;
    }
    /**
     * Divides this number using given number
     * @param self $b
     * @return self
     * @throws DivideByZeroException
     */
    public function div($b) {
        static::create($b);
        if($b->value == 0) throw new DivideByZeroException;
        static::create($b, $this->value / $b->value);
        return $b;
    }
    /**
     * Computes the modulo of this number by given number
     * @param self $b
     * @return self
     * @throws DivideByZeroException
     */
    public function module($b) {
        static::create($b);
        if($b->value == 0) throw new DivideByZeroException;
        static::create($b, $this->value % $b->value);
        return $b;
    }
    
    public function compareTo($b) {
        try {
            static::create($b);
            if($this->value == $b->value) return 0;
            else return ($this->value < $b->value) ? -1 : 1;
        }
        catch(\Exception $ex) {
            $ex = null; // IDE anti-warning trick
            return 1;
        }
    }
    
    /**
     * Checks if number is greater than given number
     * @param mixed $b
     * @return boolean
     */
    public function greaterThan($b) {
        return 0 < $this->compareTo($b);
    }
    
    /**
     * Checks if number is greater than or equals given number
     * @param mixed $b
     * @return boolean
     */
    public function greaterOrEqual($b) {
        return 0 <= $this->compareTo($b);
    }
    
    /**
     * Checks if number is lesser than given number
     * @param mixed $b
     * @return boolean
     */
    public function lessThan($b) {
        return 0 > $this->compareTo($b);
    }
    
    /**
     * Checks if number is lesser than or equals given number
     * @param mixed $b
     * @return boolean
     */
    public function lessOrEqual($b) {
        return 0 >= $this->compareTo($b);
    }
    
    /**
     * Checks if number is equals given number
     * @param mixed $b
     * @return boolean
     */
    public function equals($b) {
        return 0 == $this->compareTo($b);
    }

    protected function clear() {
        $this->value = 0;
    }
}
