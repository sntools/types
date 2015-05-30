<?php
namespace SNTools\Types;
use SNTools\Object;
use SNTools\Types\Autoboxing\Memory;

/**
 * Description of Type
 *
 * @author Darth Killer
 * @property boolean $nullable
 */
abstract class Type extends Object {
    /**
     *
     * @var mixed
     */
    protected $value;
    /**
     *
     * @var int
     */
    private $memoryId;
    
    private $_nullable = false;
    
    /**
     * 
     * @param string $name
     * @return mixed
     * @throws \DomainException
     */
    public function __get($name) {
        switch($name) {
            case 'nullable':
                return $this->_nullable;
            default:
                return parent::__get($name);
        }
    }
    
    /**
     * 
     * @param string $name
     * @param mixed $value
     * @throws \DomainException
     */
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
     * 
     * @param &mixed $var
     * @param mixed|null $value
     * @param boolean $override
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
     * 
     * @param mixed|null $value
     * @throws TypeMismatchException
     * @throws InvalidValueException
     */
    private function __construct($value = null) {
        parent::__construct();
        $this->setValue($value);
    }
    
    final public function __destruct() {
        if(!is_null($this->memoryId)) {
            $pointer =& Memory::get($this->memoryId);
            $value = $pointer;
            if($value !== $this and !is_null($value)) {
                $pointer = null;
                self::create($pointer, $value);
            }
            Memory::free($this->memoryId);
        }
    }
    
    /**
     * 
     * @param mixed $value
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
     * 
     * @param boolean $value
     * @return boolean
     */
    protected function fromBool($value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
     * @param int $value
     * @return boolean
     */
    protected function fromInt($value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
     * @param double $value
     * @return boolean
     */
    protected function fromDouble($value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
     * @param string $value
     * @return boolean
     */
    protected function fromString($value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
     * @param array $value
     * @return boolean
     */
    protected function fromArray(array $value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
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
     * 
     * @param resource $value
     * @return boolean
     */
    protected function fromResource($value) {
        return false and $value; // IDE warining trick
    }
    /**
     * 
     * @return mixed
     */
    final public function getValue() {
        return $this->value;
    }
    
    abstract protected function clear();
    
    /**
     * 
     * @return Bool
     */
    final public function toBool() {
        $bool = null;
        Bool::create($bool, $this);
        return $bool;
    }
}
