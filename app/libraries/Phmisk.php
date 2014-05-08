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
     * Store all custom varibles set by get() method
     * 
     * @access private
     */
	private $vars = array();
	
    
    /**
     * Set the value of a var
     * 
     * @param str   the item key
     * @param str   the new value 
     */    
    public function set( $var, $value ) 
    {
		$this->vars[$var] = $value;
    }


    /**
     * Get the value of an item. If null the default
     * value will be returned.
     * 
     * @param str   the item key
     * @param str   a default value 
     * @return  mix the item value, or default
     */  
    public function get( $var, $default=NULL ) 
    {
		if ( array_key_exists($var, $this->vars) )
        {
            return $this->vars[$var];
        } 
        else 
        {
             return $default; 
        } 
    }


    /**
     * Load an instance of another class as property.
     * 
     * @param str   the property key
     * @param str   the instance
     */      
    public function load( $name, &$instance ) 
    {
		$this->$name = $instance;
    }
    
}


/* EOF */
