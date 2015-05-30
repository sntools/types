<?php
namespace SNTools\Types;

/**
 * Description of UInt
 *
 * @author Darth Killer
 */
class UInt extends Int {
    protected function fromInt($value) {
        if($value < 0) throw new InvalidValueException('UInt : negative values forbidden');
        parent::fromInt($value);
    }
}
