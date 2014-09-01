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
     * @param str   	the var name, or array of vars
     * @param str|bol  	the var value, or apply the xss_clean filter
     * @param bol   	apply the xss_clean filter
     */    
    public function assign( $first, $second=FALSE, $third=FALSE ) 
    {
        if ( is_array($first) )
        {
            if ( $second ) $first = array_map_recursive( 'xssafe', $first );
            
            $this->vars = $first + $this->vars;
        }
        else
        {
            if ( $third ) $second = xssafe( $second );
            
            $this->vars[$first] = $second;
        }
    }        


    /**
     * Render the layout view 
     * 
     * @param str   the view filename without extension
     * @param bol   echo or return as string
     */    
    public function render( $file, $return_string = FALSE ) 
    {
		
		ob_start();
		extract( $this->vars );
		include UI_PATH.'/'.$file;
		$html = ob_get_clean();                
		
		if ( $return_string ) return $html; else echo $html;
    }            
}


/* EOF */
