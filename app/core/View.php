<?php 

namespace App\Core;

/**
 * View class
 *
 * This class is a quick template engine to render the app layouts.
 *
 * @package     Phmisk
 * @subpackage  Core
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */
class View
{

    /**
     * All variables to be sent to view file
     * 
     * @access private
     */
    private $vars = array();
    
        
    /**
     * Set the value of a var
     * 
     * @param str   the item key
     * @param str   the new value 
     * @param bol   apply the xss_clean filter
     */    
    public function assign( $var, $value ) 
    {
        if ( is_array($var) )
        {
            // array_map_recursive( xssafe )
            $this->vars = $var + $this->vars;
        }
        else
        {
            // TODO xssafe
            $this->vars[$var] = $value;
        }
        
                
    }        
}


/* EOF */
