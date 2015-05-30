<?php
namespace SNTools\Types;

/**
 * Description of OverrideException
 *
 * @author Darth Killer
 */
class OverrideException extends \UnexpectedValueException {
    public function __construct() {
        parent::__construct('Attempt to override a pointer', 0, null);
    }
}
