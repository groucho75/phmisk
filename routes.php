<?php if ( ! defined('ENV')) exit('No direct script access allowed');
/**
 * Phmisk Routes
 *
 * In this file you can write the site routes.
 *
 * @package     Phmisk
 * @subpackage  Routes
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */



/** -----------------------------------------------------------------
 * Sample routes
 * ------------------------------------------------------------------ */
 
 
/**
 * Custom 404 Handler
 */
$ph4->router->set404(function() use ($ph4) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

    $data = array(
        'msg'       => 'Sorry, page not found!',
        'text'      => 'This a 404 error page. What are you looking for?',
        'glyphicon' => 'glyphicon-thumbs-down'
    );
    
    $ph4->tpl->assign( $data );
    $ph4->tpl->draw( 'message' );
});



/**
 * Before Router Middleware: set config vars.
 */
$ph4->router->before('GET|POST', '/.*', function() use ( $ph4 ) {
    
    $ph4->tpl->assign( 'config', $ph4->get('config') );
    
});


/**
 * The homepage
 */
$ph4->router->get('/', function() use ( $ph4 ) {

    $data = array(
        'msg'       => 'Hello World!',
        'text'      => 'Welcome!',
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
        'msg'       => 'Readme',
        'html'      => $parsedown->parse( file_get_contents('README.md') ),
    );

    $ph4->tpl->assign( $data ); 
    $ph4->tpl->draw( 'readme' );    
});




/* EOF */
