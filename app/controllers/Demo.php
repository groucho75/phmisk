<?php

namespace App\Controllers;

class Demo extends Base
{	
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
