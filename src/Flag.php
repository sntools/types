<?php
namespace SNTools\Types;

/**
 * Description of Flag
 *
 * @author Darth Killer
 */
abstract class Flag extends Enum {
    protected function clear() {
        $this->value = 0;
    }
    protected function fromEnumValue($value) {
        /* @var $temp UInt */
        $temp = null;
        UInt::create($temp, $value);
        foreach($this->getConstants() as $flag) {
            if($temp->bw_and($flag)) $temp = $temp->bw_and (~$flag);
            elseif($temp) return false;
        }
        $this->value = $value;
        return true;
    }
}
