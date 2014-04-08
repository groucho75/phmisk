<?php if ( ! defined('ENV')) exit('No direct script access allowed');
/**
 * Phmisk Helpers
 *
 * This file contains a collection of useful functions you can use
 * freely everywhere in Phmisk.
 *
 * @package		Phmisk
 * @subpackage 	Helpers
 * @author		Alessandro Massasso <alo@eventualo.net>
 * @license		GPL
 * @link		https://github.com/groucho75/phmisk
 */
 

/**
* Redirect to another site uri.
*
* @param	str		the relative uri
* @param	int		the http code
*/
if ( ! function_exists('redirect') ) :
function redirect($uri, $code = 302) {
  @header("Location: ". BASE_URL . ltrim($uri,'/'), true, $code);
  exit;
}
endif;


/**
* Print (using "print_r") an array inside <pre> html tag.
* Useful and readable for debug purpose.
*
* @param	arr
* @return	html	
*/
if ( ! function_exists('array_pre') ) :
function array_pre( $array )
{
	echo '<pre>'. print_r( (array)$array, true ).'</pre>';
}
endif;


/**
* XSS mitigation functions
*
* @see		https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet
* @param	str
* @return	str
*/
if ( ! function_exists('xssafe') ) :
function xssafe ( $data, $encoding='UTF-8' )
{
	return htmlspecialchars( $data, ENT_QUOTES | ENT_HTML401, $encoding );
}
endif;

if ( ! function_exists('xecho') ) :
function xecho ( $data )
{
	echo xssafe( $data );
}
endif;


/* EOF */
