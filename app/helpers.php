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
* Return the current uri (relative path)
*
* @return str
* @see	https://github.com/bramus/router/blob/master/src/Bramus/Router/Router.php
*/
if ( ! function_exists('current_uri') ) :
function current_uri() {

	// Get the current Request URI and remove rewrite basepath from it (= allows one to run the router in a subfolder)
	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));

	// Don't take query params into account on the URL
	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));

	// Remove trailing slash + enforce a slash at the start
	$uri = '/' . trim($uri, '/');

	return $uri;
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


/**
 * Merges two arrays and replace existing Entrys
 *
 * Merges two Array like the PHP Function array_merge_recursive.
 * The main difference is that existing Keys will be replaced with new Values,
 * not combined in a new Sub Array.
 *
 * Usage:
 *         $newArray = array_merge_replace( $array, $newValues );
 *
 * @author 	Tobias Tom <t.tom@succont.de>
 * @param 	array $array First Array with 'replaceable' Values
 * @param 	array $newValues Array which will be merged into first one
 * @return 	array Resulting Array from replacing Process
 *
 * @link	http://php.net/manual/en/function.array-merge-recursive.php#38854
 */

if ( ! function_exists('array_merge_replace')) :
function array_merge_replace ( $array, $newValues ) 
{
	foreach ( $newValues as $key => $value ) {
		if ( is_array( $value ) ) {
			if ( !isset( $array[ $key ] ) ) {
				$array[ $key ] = array();
			}
			$array[ $key ] = array_merge_replace( $array[ $key ], $value );
		} else {
			if ( isset( $array[ $key ] ) && is_array( $array[ $key ] ) ) {
				$array[ $key ][ 0 ] = $value;
			} else {
				if ( isset( $array ) && !is_array( $array ) ) {
					$temp = $array;
					$array = array();
					$array[0] = $temp;
				}
				$array[ $key ] = $value;
			}
		}
	}
	return $array;
}
endif;


/**
 * Order a multimensional array (or an array of objects) by a certain key.
 * 
 * Usage:
 * 			array_multidim_sort( $array, 'key_name' );
 */

if ( ! function_exists('array_multidim_sort')) :
function array_multidim_sort (&$array, $key, $asc=TRUE) 
{
	if ( ! function_exists('build_sorter'))
	{
		function build_sorter($key, $asc) {
			return function ($a, $b) use ($key, $asc) {
				if ( is_object($a) && is_object($b) )
				{
					$comparison = strcasecmp($a->$key, $b->$key);
					return ( $asc ) ? $comparison : -1*( $comparison );
				}
				else
				{
					$comparison = strcasecmp($a[$key], $b[$key]);
					return ( $asc ) ? $comparison : -1*( $comparison );
				}
			};
		}
	}
	usort( $array, build_sorter($key, $asc) );
}
endif;


/**
 * Make a recursive mapping (infact array_map gives error if some array
 * element is array).
 * 
 * @see		http://www.php.net/manual/en/function.array-map.php#107808
 */

if ( ! function_exists('array_map_recursive')) :
function array_map_recursive($fn, $arr) {
	$rarr = array();
	foreach ($arr as $k => $v) {
		$rarr[$k] = is_array($v) ? array_map_recursive($fn, $v) : call_user_func($fn, $v);
	}
	return $rarr;
}	
endif;


/**
 * Return datetime in mysql format: YYYY-MM-DD HH:MM:SS
 * 
 * @return 	str		
 */

if ( ! function_exists('now')) :
function now() {
	return date('Y-m-d H:i:s');
}	
endif;


/* EOF */
