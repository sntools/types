<?php
namespace SNTools\Types;

/**
 * Description of String
 *
 * @author Darth Killer
 */
class String extends AbstractString {
    public function concat($string) {
        self::create($string);
        /* @var $string String */
        self::create($string, $this->value . $string->value);
        return $string;
    }
}
