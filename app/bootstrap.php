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
 * Init the ORM Database layer
 *
 * @link	https://github.com/mardix/VoodOrm
 * @link	http://mardix.github.io/VoodOrm/
 */
try {
	$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db = new \Voodoo\VoodOrm($pdo);
} catch( PDOException $e ) {
	echo '<strong>Impossibile to connect to database: please check the parameters provided in /app/config.php.</strong><br />'. $e->getMessage();
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
 * Init the Router
 *
 * @link	https://github.com/bramus/router
 */
$router = new \Bramus\Router\Router();


/* EOF */
