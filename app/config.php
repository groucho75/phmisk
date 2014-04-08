<?php if ( ! defined('ENV')) exit('No direct script access allowed');
/**
 * Phmisk Configuration file
 *
 * In this file you can set some configuration vars: php settings,
 * database connection parameters, more custom variables.
 *
 * @package		Phmisk
 * @subpackage 	Configuration
 * @author		Alessandro Massasso <alo@eventualo.net>
 * @license		GPL
 * @link		https://github.com/groucho75/phmisk
 */

 

/**
 * Php headers and general settings
 *
 * Customize as you need.
 */
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
header('Content-Type: text/html; charset=utf-8'); 

@ini_set( 'upload_max_size' , '100M' );
@ini_set( 'post_max_size', '100M');
@ini_set( 'max_execution_time', '600' );
@ini_set( "memory_limit", "1024M" );

@date_default_timezone_set( 'Europe/Berlin' );


/**
 * Database settings.
 *
 * Set here the connection parameter. You can use ENV value to manage
 * different database connections related to app environment,
 */
switch ( ENV )
{
	case 'dev':
	case 'test':
	case 'live':
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PASS', 'root');
		define('DB_NAME', 'test');
	break;
}


/**
 * More configs.
 *
 * Feel free to create vars and use them in templates.
 */
$config['site_title'] 		= 'My amazing site';
$config['site_description']	= 'My amazing site description';


/* EOF */
