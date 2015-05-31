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
use SNTools\Object;
use SNTools\Types\Autoboxing\Memory;

/**
 * Superclass for all autoboxed types.
 * This class fills the role of the AutoBoxedObject class, according to the Autoboxing technique from Arthur Graniszewski
 *
 * @link http://www.phpclasses.org/package/6570-PHP-Wrap-string-and-integer-values-in-objects.html Arthur Graniszewski's Autoboxing classes
 * @author Samy NAAMANI <samy@namani.net>
 * @license https://github.com/sntools/types/blob/master/LICENSE MIT
 * @property boolean $nullable Is the element nullable or not ?
 */
abstract class Type extends Object {
    /**
     * Real value
     * @var mixed
     */
    protected $value;
    /**
     * Memory variable
     * @var int
     */
    private $memoryId;

    /**
     * Is the element nullable or not ?
     * @var boolean
     * @see Type::$nullable
     */
    private $_nullable = false;
    
    public function __get($name) {
        switch($name) {
            case 'nullable':
                return $this->_nullable;
            default:
                return parent::__get($name);
        }
    }
    
    public function __set($name, $value) {
        switch($name) {
            case 'nullable':
                $this->_nullable = (bool)$value;
                break;
            default:
                parent::__set($name, $value);
        }
    }
    
    /**
     * Create a new autoboxed variable
     * @param &mixed $var Reference to the variable to create
     * @param mixed|null $value If not null, value to use to override referenced variable
     * @param boolean $override If neither $var nor $value, allow override of $var or not
     * @throws TypeMismatchException
     * @throws InvalidValueException
     * @throws OverrideException
     */
    final public static function create(&$var, $value = null, $override = false) {
        if(!is_null($var)) {
            if(is_null($value)) $value = $var;
            elseif(!$override) throw new OverrideException;
        }
        
        if($value instanceof static) {
            $var = clone $value;
        } else {
            $var = new static($value);
        }
        $var->memoryId = Memory::alloc($var);
    }
    
    /**
     * Private constructor. Use Type::create() instead.
     * @param mixed|null $value
     * @throws TypeMismatchException
     * @throws InvalidValueException
     */
    private function __construct($value = null) {
        parent::__construct();
        $this->setValue($value);
    }

    /**
     * Destructor. Frees variable from memory, OR creates a new variable from previous one
     * @ignore
     */
    final public function __destruct() {
        if(!is_null($this->memoryId)) {
            $pointer =& Memory::get($this->memoryId);
            $value = $pointer;
            if($value !== $this and !is_null($value)) {
                $pointer = null;
                static::create($pointer, $value);
            }
            Memory::free($this->memoryId);
        }
    }
    
    /**
     * Sets value into variable
     * @param mixed $value Value to use
     * @throws TypeMismatchException
     * @throws InvalidValueException
     */
    final protected function setValue($value) {
        switch(gettype($value)) {
            case 'boolean':
                $ok = $this->fromBool($value);
                break;
            case 'integer':
                $ok = $this->fromInt($value);
                break;
            case 'double':
            case 'string':
            case 'array':
            case 'object':
            case 'resource':
                $method = 'from' . ucfirst(gettype($value));
                $ok = $this->$method($value);
                break;
            case 'NULL':
                if($this->nullable) $this->value = null;
                else $this->clear();
                $ok = true;
                break;
            default:
                throw new TypeMismatchException(sprintf('Unexpected type %s for %s', gettype($value), get_called_class ()));
        }
        if(!$ok) throw new InvalidValueException(sprintf('Unexpected value %s for %s', $value, get_called_class ()));
    }
    /**
     * Checks variable creation from boolean
     * @param boolean $value
     * @return boolean
     */
    protected function fromBool($value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Check variable creation from integer
     * @param int $value
     * @return boolean
     */
    protected function fromInt($value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Check variable creation from double
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Check variable creation from string
     * @param string $value
     * @return boolean
     */
    protected function fromString($value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Check variable creation from array
     * @param array $value
     * @return boolean
     */
    protected function fromArray(array $value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Check variable creation from object
     * @param object $value
     * @return boolean
     */
    protected function fromObject($value) {
        if($value instanceof self) {
            $this->setValue($value->value);
            return true;
        } else return false;
    }
    /**
     * Check variable creation from resource
     * @param resource $value
     * @return boolean
     */
    protected function fromResource($value) {
        return false and $value; // IDE anti-warning trick
    }
    /**
     * Get inner value
     * @return mixed
     */
    final public function getValue() {
        return $this->value;
    }

    /**
     * clears inner value, setting it to a default value
     */
    abstract protected function clear();
    
    /**
     * Conversion to boolean
     * @return Bool
     */
    final public function toBool() {
        $bool = null;
        Bool::create($bool, $this);
        return $bool;
    }

    /**
     * (bool) operator overriding
     * @return boolean
     * @todo Query : return a native boolean or a Bool object ?
     */
    public function __bool() {
        return $this->toBool()->getValue();
    }

    /**
     * ! operator overriding
     * @return boolean
     * @todo Query : return a native boolean or a Bool object ?
     */
    public function __bool_not() {
        return !$this->__bool();
    }
}
