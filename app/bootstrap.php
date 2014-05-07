<?php if ( ! defined('ENV')) exit('No direct script access allowed');
/**
 * Phmisk Bootstrap file
 *
 * Main classes are initialised in this file: the router, the template engine, the database connection.
 *
 * @package		Phmisk
 * @subpackage 	Bootstrap
 * @author		Alessandro Massasso <alo@eventualo.net>
 * @license		GPL
 * @link		https://github.com/groucho75/phmisk
 */
 

/**
 * Load configuration
 */
require __DIR__ . '/config.php';


/**
 * Set error reporting level
 */
if ( ENV == 'live' )
{
	error_reporting(0);
	@ini_set('display_errors', '0');
}
else
{
	error_reporting(E_ALL);
	@ini_set('display_errors', '1');
}


/**
 * Set the base url as a constant.
 *
 * It will be used in app and template files. With a trailing slash.
 */
$base_url = ( (isset($_SERVER['HTTPS']) ) ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$base_url = rtrim( $base_url,'/').'/'; 
define('BASE_URL', $base_url);


/**
 * Set the current URI (relative path) into a constant 
 */
define('CURRENT_URI', current_uri() );


/**
 * Init the Php Html Micro Starter Kit!
 */
$ph4 = new App\Libraries\Phmisk($config);


/* EOF */
