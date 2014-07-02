<?php
/**
 * Phmisk: Php Html MIcro Starter Kit
 *
 * Phmisk is a starter kit to make a php/html site, it comes with an html5 UI, a router, a template engine, an ORM database layer.
 *
 * @package		Phmisk
 * @author		Alessandro Massasso <alo@eventualo.net>
 * @license		GPL
 * @link		https://github.com/groucho75/phmisk
 */



/** -----------------------------------------------------------------
 * Setup section
 * ------------------------------------------------------------------ */
 
 
/**
 * Set the environment: 'dev', 'test', 'live'
 */
define('ENV', 'dev');


/**
 * Set the path to 'app' folder, without slashes. Default: 'app'
 * For security you can move it above web root, e.g.: '../app'
 */
define('APP_PATH', 'app');




/** -----------------------------------------------------------------
 * Load & init Phmisk
 * ------------------------------------------------------------------ */
 
 
/**
 * If 'vendor' folder does not exist, stop and alert
 */
if ( ! is_dir(APP_PATH . '/vendor') )
{
	die('<h1>Ehi!</h1><strong>You have to launch <a href="https://getcomposer.org/doc/00-intro.md#installation-nix" target="_blank">Composer installation</a> to make Phmisk ready to work!</strong>');
}


/**
 * Composer autoload
 */
require __DIR__ .'/'. APP_PATH . '/vendor/autoload.php';


/**
 * Init the application
 */
require __DIR__ .'/'. APP_PATH . '/bootstrap.php';


/**
 * Load the routes
 */
require __DIR__ .'/routes.php';
	

/**
 * ...let's go!
 */
$ph4->router->run();



/* EOF */
