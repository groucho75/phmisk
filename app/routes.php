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
 * Sample routes (you can edit them as you need)
 * ------------------------------------------------------------------ */
 
 
/**
 * Custom 404 Handler
 */
$ph4->router->set404(function() use ($ph4) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');

    $data = array(
        'title'     => 'Sorry, page not found!',
        'text'      => 'This a 404 error page. What are you looking for?',
        'glyphicon' => 'glyphicon-thumbs-down'
    );
    
    $ph4->view->assign( $data, true );
    $ph4->view->render( 'message' );
});



/**
 * Before Router Middleware: set config vars.
 */
$ph4->router->before('GET|POST', '/.*', function() use ( $ph4, $config ) {
    
    $ph4->view->assign( 'config', $config );
    
});


/**
 * The homepage
 */
$ph4->router->get('/', function() use ( $ph4 ) {

    $data = array(
        'title'     => 'Hello World!',
        'text'      => 'Welcome!',
    );
    
    $ph4->view->assign( $data, true ); 
    $ph4->view->render( 'home' );
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
        'title'     => 'Readme',
        'html'      => $parsedown->parse( file_get_contents('README.md') ),
    );

    $ph4->view->assign( $data ); 
    $ph4->view->render( 'readme' );    
});



/** -----------------------------------------------------------------
 * Now write your custom routes here
 * ------------------------------------------------------------------ */
 




/* EOF */
