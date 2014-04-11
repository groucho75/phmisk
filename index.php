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


/**
 * If 'vendor' folder does not exist, stop and alert
 */
if ( ! is_dir('vendor') )
{
	die('<h1>Ehi!</h1><strong>You have to launch <a href="https://getcomposer.org/doc/00-intro.md#installation-nix" target="_blank">Composer installation</a> to make Phmisk ready to work!</strong>');
}

 
/**
 * Set the environment: 'dev', 'test', 'live'
 */
define('ENV', 'dev');


/**
 * Set the base url as a constant.
 *
 * It will be used in app and template files.
 */
$base_url = ( (isset($_SERVER['HTTPS']) ) ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$base_url = rtrim( $base_url,'/').'/'; // add a trailing slash
define('BASE_URL', $base_url);



/**
 * Composer autoload
 */
require __DIR__ . '/vendor/autoload.php';


/**
 * Init the application
 */
require __DIR__ . '/app/bootstrap.php';


	
/**
 * Custom 404 Handler
 */
$router->set404(function() use ($tpl) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

	$data = array(
		'msg' 		=> 'Sorry, page not found!',
		'text'		=> 'This a 404 error page. What are you looking for?',
		'glyphicon' => 'glyphicon-thumbs-down'
	);
	
	$tpl->assign( $data );
    $tpl->draw( 'message' );
});


/**
 * Before Router Middleware
 */
$router->before('GET|POST', '/.*', function() use ( $tpl, $config ) {
	
	$tpl->assign( 'config', $config );
	
});


/**
 * The homepage
 */
$router->get('/', function() use ( $tpl ) {

	$data = array(
		'msg' 		=> 'Hello World!',
		'text'		=> 'Welcome!',
	);
	
	$tpl->assign( $data );	
    $tpl->draw( 'home' );
});


/**
 * Map a custom class/method as a route
 */
$demo = new App\Controllers\Demo();

$router->get('/test', function() use ( $demo, $tpl ) {
	
	$demo->test($tpl);
});


// Run it!
$router->run();


/* EOF */
