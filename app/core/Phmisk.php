<?php 

namespace App\Core;

/**
 * Main Phmisk class
 *
 * This class creates the main Phmisk object that contains the main
 * classes.
 *
 * @package     Phmisk
 * @subpackage  Core
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
     * Usage:
     * $ph4->load( 'myclass' )  		=> $ph4->myclass
     * $ph4->load( 'myclass', 'my' )  	=> $ph4->my
     * 
     * @param str   the instance
     * @param str   the instance name used to name the property
     */      
    public function load( &$instance, $name=NULL ) 
    {
		$property = ( ! empty($name) ) ? $name : $this->var_name($instance);
		$this->$property = $instance;
    }
    

    /**
     * Return the name of a variable.
     * 
     * @param mix   the var
     * @return str   the var name
     */   
	private function var_name($var) 
	{
		foreach($GLOBALS as $var_name => $value) {
			if ($value === $var) {
				return $var_name;
			}
		}
		return FALSE;
	}    
	
}


/* EOF */
