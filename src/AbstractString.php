<?php
namespace SNTools\Types;

/**
 * Description of AbstractString
 *
 * @author Darth Killer
 */
abstract class AbstractString extends Type {
    protected function clear() {
        $this->value = '';
    }
    protected function fromString($value) {
        $this->value = $value;
        return true;
    }
    protected function fromArray(array $value) {
        return $this->fromString(serialize($value));
    }
    protected function fromBool($value) {
        return $this->fromString(strval($value));
    }
    protected function fromDouble($value) {
        return $this->fromString(strval($value));
    }
    protected function fromInt($value) {
        return $this->fromString(strval($value));
    }
    final public function __toString() {
        return $this->value;
    }
    final public function isEmpty() {
        return empty($this->value);
    }
    final public function match($regex) {
        Regex::create($regex);
        return false !== $regex->match($this->value);
    }
}
