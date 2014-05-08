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
 * Init the ORM Database layer
 *
 * @link	https://github.com/mikecao/sparrow
 * @link	https://packagist.org/packages/unlight/sparrow
 */
$pdo = FALSE;
$db = FALSE; 
if ( DB_USER != '' && DB_NAME != '' )
{
    try {
    	$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$pdo->exec("SET NAMES 'utf8';");
    	
    	$db = new \Sparrow();
        $db->setDb($pdo);
    } catch( PDOException $e ) {
    	echo '<strong>Impossibile to connect to database: please check the parameters provided in /app/config.php.</strong><br />'. $e->getMessage();
    }
}
    

/**
 * Init the template engine
 *
 * @link	http://www.raintpl.com
 * @link	https://github.com/rainphp/raintpl3/wiki
 */
$tpl = new \Rain\Tpl();
$tpl::configure( array(
	"base_url"		=> BASE_URL,
	"tpl_ext"		=> "php",
	'php_enabled'	=> true,
	"tpl_dir"       => "ui/",
	"cache_dir"     => "app/cache/"
));


/**
* Init the session class
*
* @see /app/libraries/Session.php
*/	
$sess = new App\Libraries\Session();


/**
 * Init the Router
 *
 * @link	https://github.com/bramus/router
 */
$router = new \Bramus\Router\Router();


/**
 * Init the Php Html Micro Starter Kit
 * and assign config and all instances to it.
 */
$ph4 = new App\Libraries\Phmisk();
 
$ph4->set( 'config', $config );

$ph4->load( $pdo );
$ph4->load( $db );
$ph4->load( $tpl );
$ph4->load( $sess );
$ph4->load( $router );


/* EOF */
