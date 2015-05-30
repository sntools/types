<?php
namespace SNTools\Types;

/**
 * Description of Bool
 *
 * @author Darth Killer
 */
class Bool extends Type {
    protected function clear() {
        $this->value = false;
    }
    protected function fromBool($value) {
        $this->value = (bool)$value;
        return true;
    }
    protected function fromArray(array $value) {
        return $this->fromBool($value);
    }
    protected function fromDouble($value) {
        return $this->fromBool($value);
    }
    protected function fromInt($value) {
        return $this->fromBool($value);
    }
    protected function fromObject($value) {
        return $this->fromBool($value);
    }
    protected function fromResource($value) {
        return $this->fromBool($value);
    }
    protected function fromString($value) {
        return $this->fromBool($value);
    }

    /**
     * 
     * @return Int
     */
    final public function toInt() {
        $int = null;
        Int::create($int, $this);
        return $int;
    }
}
