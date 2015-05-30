<?php
namespace SNTools\Types;

/**
 * Description of Number
 *
 * @author Darth Killer
 */
abstract class Number extends Type implements Comparable {
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
    public function add($b) {
        self::create($b);
        static::create($b, $this->value + $b->value);
        return $b;
    }
    public function sub($b) {
        self::create($b);
        static::create($b, $this->value - $b->value);
        return $b;
    }
    public function times($b) {
        self::create($b);
        static::create($b, $this->value * $b->value);
        return $b;
    }
    public function div($b) {
        self::create($b);
        if($b->value == 0) throw new DivideByZeroException;
        static::create($b, $this->value / $b->value);
        return $b;
    }
    public function module($b) {
        self::create($b);
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
            $ex = null; // IDE warining trick
            return 1;
        }
    }
    
    /**
     * 
     * @param mixed $b
     * @return boolean
     */
    public function greaterThan($b) {
        return 0 < $this->compareTo($b);
    }
    
    /**
     * 
     * @param mixed $b
     * @return boolean
     */
    public function greaterOrEqual($b) {
        return 0 <= $this->compareTo($b);
    }
    
    /**
     * 
     * @param mixed $b
     * @return boolean
     */
    public function lessThan($b) {
        return 0 > $this->compareTo($b);
    }
    
    /**
     * 
     * @param mixed $b
     * @return boolean
     */
    public function lessOrEqual($b) {
        return 0 >= $this->compareTo($b);
    }
    
    /**
     * 
     * @param mixed $b
     * @return boolean
     */
    public function equals($b) {
        return 0 == $this->compareTo($b);
    }
}
