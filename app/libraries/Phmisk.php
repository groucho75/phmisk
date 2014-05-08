<?php 

namespace App\Libraries;

/**
 * Main Phmisk class
 *
 * This class creates the main Phmisk object that contains the main
 * classes.
 *
 * @package     Phmisk
 * @subpackage  Libraries
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */
class Phmisk
{

    /**
     * Load all the passed class instances
     */      
    public function __construct( $instances ) 
    {
		foreach ( $instances as $name => $inst )
			$this->$name = $inst;
    }

}


/* EOF */
