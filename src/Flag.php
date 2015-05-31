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
 * Flag wrapper. This special type of enumeration expects integers as constant values, to be able to detect bitwise combinaisons
 *
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 */
abstract class Flag extends Enum {
    protected function clear() {
        $this->value = 0;
    }
    protected function fromEnumValue($value) {
        /* @var $temp UInt */
        $temp = null;
        UInt::create($temp, $value);
        foreach($this->getConstants() as $flag) {
            if($temp->bw_and($flag)) $temp = $temp->bw_and (~$flag);
            elseif($temp) return false;
        }
        $this->value = $value;
        return true;
    }
    public function getConstName() {
        $default = parent::getConstName();
        if($default === false) {
            return 'Combinaison of flags';
        } else return $default;
    }
}
