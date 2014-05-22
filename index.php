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
 * Set the path to 'app' folder, without slashes. Default: 'app'
 * For security you can move it above web root, e.g.: '../app'
 */
define('APP_PATH', 'app');


/**
 * Composer autoload
 */
require __DIR__ . '/vendor/autoload.php';


/**
 * Init the application
 */
require __DIR__ .'/'. APP_PATH . '/bootstrap.php';



/** -----------------------------------------------------------------
 * Start editing your routing
 * ------------------------------------------------------------------ */
 
	
/**
 * Custom 404 Handler
 */
$ph4->router->set404(function() use ($ph4) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

	$data = array(
		'msg' 		=> 'Sorry, page not found!',
		'text'		=> 'This a 404 error page. What are you looking for?',
		'glyphicon' => 'glyphicon-thumbs-down'
	);
	
	$ph4->tpl->assign( $data );
    $ph4->tpl->draw( 'message' );
});


/**
 * Before Router Middleware
 */
$ph4->router->before('GET|POST', '/.*', function() use ( $ph4 ) {
	
	$ph4->tpl->assign( 'config', $ph4->get('config') );
	
});


/**
 * The homepage
 */
$ph4->router->get('/', function() use ( $ph4 ) {

	$data = array(
		'msg' 		=> 'Hello World!',
		'text'		=> 'Welcome!',
	);
	
	$ph4->tpl->assign( $data );	
    $ph4->tpl->draw( 'home' );
});



/**
 * Map a custom class/method as a route
 */
$demo = new App\Controllers\Demo();

$ph4->router->get('/test', function() use ( $demo, $ph4 ) {
	
	$demo->test($ph4);
});


/**
 * Render the README.md as pure html
 */
$ph4->router->get('/readme', function() use ( $ph4 ){
	$parsedown = new Parsedown();

	$data = array(
		'msg' 		=> 'Readme',
		'html'		=> $parsedown->parse( file_get_contents('README.md') ),
	);

	$ph4->tpl->assign( $data );	
    $ph4->tpl->draw( 'readme' );	
});


/**
 * Run it!
 */
$ph4->router->run();



/* EOF */
