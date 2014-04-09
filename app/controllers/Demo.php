<?php

namespace App\Controllers;

/**
 * Demo Custom controller
 *
 * This file contains a sample custom controller class. 
 * You can edit it or create other custom controllers in this folder:
 * they will be autoloaded.
 *
 * @package     Phmisk
 * @subpackage  Controllers
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */
class Demo extends Base
{
    
   /**
    * Test medthod
    *
    * @param    obj     the template instance
    */    	
	function test($tpl) 
	{
		$data = array(
			'msg' 		=> 'Demo->test()',
			'text'		=> 'This page has been created by Test method of Demo custom controller, located in: app/controllers/Demo.php'
		);
				
		$tpl->assign( $data );
		$tpl->draw( 'message' );			
	}

}

/* EOF */
