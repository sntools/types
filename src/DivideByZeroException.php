<?php
namespace SNTools\Types;

/**
 * Description of DivideByZeroException
 *
 * @author Darth Killer
 */
class DivideByZeroException extends \UnexpectedValueException {
    public function __construct(\Exception $previous = null) {
        parent::__construct('Attempted dividing by zero.', 0, $previous);
    }
}
