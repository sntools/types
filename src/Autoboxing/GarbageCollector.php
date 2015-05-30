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

namespace SNTools\Types\Autoboxing;

/**
 * Description of GarbageCollector
 *
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 * @ignore
 */
final class GarbageCollector {
    const CYCLE_MAX = 10000;
    
    /**
     *
     * @var Memory
     */
    private static $memory = null;
    
    /**
     * 
     * @param Memory &$memory
     */
    public static function setMemory(Memory &$memory) {
        self::$memory =& $memory;
    }

    public static function unsetMemory() {
        self::$memory = null;
    }
    
    private function __construct() {}
    
    /**
     * 
     * @param &mixed $var
     * @return int
     */
    private static function refCount(&$var) {
        ob_start();
        debug_zval_dump(array(&$var));
        return preg_replace('#^.+refcount\((\d+)\)\s*$#ms', '$1', ob_get_clean()) - 4;
    }
    
    /**
     * @param int $ref_cycle
     * @return int
     */
    public static function collect() {
        $collected = 0;
        if(!is_null(self::$memory) and (0 == (count(self::$memory) % self::CYCLE_MAX))) {
            foreach(self::$memory as $address => $var) {
                if(self::refCount($var) == 0) {
                    unset(self::$memory[$address]);
                    $collected++;
                }
            }
        }
        return $collected;
    }
}
