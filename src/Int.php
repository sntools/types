<?php
namespace SNTools\Types;

/**
 * Description of Int
 *
 * @author Darth Killer
 */
class Int extends Number {
    protected function fromInt($value) {
        $this->value = $value;
        return true;
    }
    protected function fromDouble($value) {
        return $this->fromInt((int)$value);
    }
    protected function clear() {
        $this->value = 0;
    }
    
    public function bw_and($b) {
        self::create($b);
        self::create($b, $this->value & $b->value);
        return $b;
    }
    public function bw_or($b) {
        self::create($$b);
        static::create($b, $this->value | $b->value);
        return $b;
    }
    public function bw_xor($b) {
        self::create($$b);
        static::create($b, $this->value ^ $b->value);
        return $b;
    }
    public function bw_not() {
        $new = null;
        static::create($new, ~$this->value);
        return $new;
    }
    public function bw_shift_left($b) {
        self::create($b);
        static::create($b, $this->value << $b->value);
        return $b;
    }
    public function bw_shift_right($b) {
        self::create($b);
        static::create($b, $this->value >> $b->value);
        return $b;
    }
}
