<?php 

namespace App\Libraries;

/**
 * Httpauth class
 *
 * This class uses header() function to send an "Authentication Required" 
 * message to the client browser causing it to pop up a 
 * Username/Password input window.
 * It implements a simple Digest HTTP authentication script.
 *
 * @package     Phmisk
 * @subpackage  Libraries
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 * @link		http://www.php.net/manual/en/features.http-auth.php
 */
class Httpauth
{
	var $realm	= '';
	var $nonce	= '';
	
	
	/**
	 * __construct
	 * @param    str     the realm
	 */    	
	function __construct( $realm='Reserved area' ) 
	{
		$this->realm = $realm;
		$this->nonce = uniqid();
	}


	/**
	 * Check the client authorization
	 * 
	 * @param    arr   	allowed users (TODO database table)
	 * @param    bol   	promt login only once
	 */    
	function checkAuth( $users=array(), $prompt_once=false ) 
	{
		if (empty($_SERVER['PHP_AUTH_DIGEST'])) 
		{	
			$this->promptLogin();
		}

		// analyze the PHP_AUTH_DIGEST variable
		if ( !($data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) )
		{
			if ( ! $prompt_once ) $this->promptLogin();
			return FALSE;
		}
		
		
		// TODO controllare contro users in database
		
		
		if ( !isset($users[$data['username']]) ) 
		{
			if ( ! $prompt_once ) $this->promptLogin();
			return FALSE;
		}			

		// generate the valid response
		$A1 = md5($data['username'] . ':' . $this->realm . ':' . $users[$data['username']]);
		$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
		$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

		if ($data['response'] != $valid_response)
		{
			if ( ! $prompt_once ) $this->promptLogin();
			return FALSE;
		}
			

		return TRUE;
	}


	/**
	 * Parse the http digest
	 * 
	 * @param    $txt	the digest string
	 */ 
	function http_digest_parse($txt)
	{
		// protect against missing data
		$needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
		$data = array();
		$keys = implode('|', array_keys($needed_parts));

		preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

		foreach ($matches as $m) 
		{
			$data[$m[1]] = $m[3] ? $m[3] : $m[4];
			unset($needed_parts[$m[1]]);
		}

		return $needed_parts ? false : $data;
	}


	/**
	 * Prompt the login.
	 * 
	 * If fails redirect to home.
	 */ 
	function promptLogin() 
	{
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Digest realm="'.$this->realm.'",qop="auth",nonce="'.$this->nonce.'",opaque="'.md5($this->realm).'"');
		
		echo '<meta http-equiv="refresh" content="0; url='.BASE_URL.'">';
		die();
	}
		
}


/* EOF */
