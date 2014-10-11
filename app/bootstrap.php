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
 * Detect if the request is an AJAX request, or a standard HTTP request.
 */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


/**
 * Init the Php Html Micro Starter Kit
 * and assign config and all instances to it.
 */
$ph4 = new App\Core\Phmisk();


/**
 * Init the ORM Database layer
 *
 * @link	https://github.com/mikecao/sparrow
 * @link	https://packagist.org/packages/unlight/sparrow
 */
$ph4->pdo = FALSE;
$ph4->db = FALSE; 
if ( DB_USER != '' && DB_NAME != '' )
{
    try {
    	$ph4->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    	$ph4->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$ph4->pdo->exec("SET NAMES 'utf8';");
    	
    	$ph4->db = new \Sparrow();
        $ph4->db->setDb($ph4->pdo);
    } catch( PDOException $e ) {
    	echo '<strong>Impossibile to connect to database: please check the parameters provided in /app/config.php.</strong><br />'. $e->getMessage();
    }
}
    

/**
* Init the view class
*
* @see /app/libraries/View.php
*/	
$ph4->view = new App\Core\View();


/**
* Init the session class
*
* @see /app/libraries/Session.php
*/	
$ph4->sess = new App\Core\Session();


/**
 * Init the Router
 *
 * @link	https://github.com/bramus/router
 */
$ph4->router = new \Bramus\Router\Router();



/* EOF */
