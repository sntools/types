<?php
namespace SNTools\Types;

/**
 * Description of Regex
 *
 * @author Darth Killer
 */
class Regex extends AbstractString {
    public function match($input) {
        String::create($input);
        return preg_match($this->value, $input->value, $matches) ? $matches : false;
    }
}
