<?php

/*
 * The MIT License
 *
 * Copyright 2015 Samy Naamani.
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
 * Interface implementing bitwise operations
 * @author Samy Naamani
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 */
interface FlagInterface {
    /**
     * Bitwise OR
     * @param self $val
     * @return self
     */
    public function bw_or($val);

    /**
     * | operator override
     * @param mixed $val
     * @return self
     */
    public function __bw_or($val);

    /**
     * Bitwise AND
     * @param self $val
     * @return self
     */
    public function bw_and($val);

    /**
     * & operator override
     * @param mixed $val
     * @return self
     */
    public function __bw_and($val);

    /**
     * Bitwise XOR
     * @param self $val
     * @return self
     */
    public function bw_xor($val);

    /**
     * ^ operator override
     * @param mixed $val
     * @return boolean
     */
    public function __bw_xor($val);

    /**
     * Bitwise NOT
     * @return self
     */
    public function bw_not();

    /**
     * ~ operator override
     * @return boolean
     */
    public function __bw_not();
}
