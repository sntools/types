<?php
namespace SNTools\Types;

/**
 *
 * @author Darth Killer
 */
interface Comparable {
    /**
     * 
     * @param mixed $b
     * @return int
     */
    public function compareTo($b);
}
