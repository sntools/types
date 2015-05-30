<?php
namespace SNTools\Types;

/**
 * Description of EMail
 *
 * @author Darth Killer
 */
class EMail extends AbstractString {
    protected function clear() {
        $this->value = null;
    }
    protected function fromString($value) {
        if(filter_var($value, FILTER_VALIDATE_EMAIL))
            return parent::fromString($value);
        else return false;
    }
    public function hasExtension() {
        return $this->match('#@[^.]+(\.[^.]+)+$#');
    }
}
