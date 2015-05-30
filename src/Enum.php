<?php
namespace SNTools\Types;

/**
 * Description of Enum
 *
 * @author Darth Killer
 */
abstract class Enum extends Type {
    /**
     * 
     * @return array
     */
    final protected function getConstants() {
        $refl = new \ReflectionClass(get_called_class());
        return array_unique($refl->getConstants());
    }
    protected function clear() {
        $this->value = null;
    }
    protected function fromEnumValue($value) {
        if(in_array($value, $this->getConstants(), true)) {
            $this->value = $value;
            return true;
        } else return false;
    }
    final protected function fromArray(array $value) {
        return $this->fromEnumValue($value);
    }
    final protected function fromBool($value) {
        return $this->fromEnumValue($value);
    }
    final protected function fromDouble($value) {
        return $this->fromEnumValue($value);
    }
    final protected function fromInt($value) {
        return $this->fromEnumValue($value);
    }
    final protected function fromObject($value) {
        $ok = parent::fromObject($value);
        return $ok ? true : $this->fromEnumValue($value);
    }
    final protected function fromResource($value) {
        return $this->fromEnumValue($value);
    }
    final protected function fromString($value) {
        return $this->fromEnumValue($value);
    }
    final public function getConstName() {
        return array_search($this->value, $this->getConstants());
    }
}
