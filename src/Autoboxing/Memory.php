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
 * Description of Memory
 *
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 * @ignore
 */
final class Memory implements \Iterator, \Countable, \ArrayAccess{
    /**
     *
     * @var &mixed[]
     */
    private $pointers = array();
    
    /**
     *
     * @var int
     */
    private static $lastAddress = -1;
    
    private function __construct() {
        GarbageCollector::setMemory(&$this);
    }

    /**
     * 
     * @return int
     */
    public function count() {
        return count($this->pointers);
    }

    /**
     * 
     * @return &mixed
     */
    public function current() {
        return current($this->pointers);
    }

    /**
     * 
     * @return int
     */
    public function key() {
        return key($this->pointers);
    }

    public function next() {
        next($this->pointers);
    }

    public function rewind() {
        reset($this->pointers);
    }

    /**
     * 
     * @return boolean
     */
    public function valid() {
        return !is_null($this->key());
    }
    
    public function offsetExists($offset) {
        return isset($this->pointers[$offset]);
    }
    
    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? $this->pointers[$offset] : null;
    }
    
    public function offsetSet($offset, &$value) {
        $this->pointers[$offset] =& $value;
    }
    
    public function offsetUnset($offset) {
        unset($this->pointers[$offset]);
    }
    
    /**
     * 
     * @staticvar Memory $instance
     * @return Memory
     */
    private static function getInstance() {
        static $instance = null;
        if(is_null($instance)) $instance = new self();
        return $instance;
    }
    
    /**
     * 
     * @param &mixed $var
     * @return int
     * @throws OutOfMemoryException
     */
    public static function alloc(&$var) {
        $memory = self::getInstance();
        GarbageCollector::collect(); // GC checks cycles to know if it has to actually collect or not
        if(self::$lastAddress < PHP_INT_MAX) {
            $memory[++self::$lastAddress] =& $var;
            return self::$lastAddress;
        }
        elseif(count($memory) == PHP_INT_MAX) throw new OutOfMemoryException;
        else {
            do {
                $address = rand(1, PHP_INT_MAX);
            }while(isset($memory[$address]));
            $memory[$address] =& $var;
            return $address;
        }
    }
    
    public static function &get($id) {
        $memory = self::getInstance();
        return $memory[$id];
    }
    
    public static function free($id) {
        $memory = self::getInstance();
        unset($memory[$id]);
    }
}
