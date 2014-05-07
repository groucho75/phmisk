<?php 

namespace App\Libraries;

/**
 * Main Phmisk class
 *
 * This class creates the main Phmisk object that contains the main
 * classes.
 *
 * @package     Phmisk
 * @subpackage  Libraries
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */
class Phmisk
{

    /**
     * Start the session.
     * 
     * Init the php session, often regenerate the session id,
     * update/delete the flash msgs.
     */      
    public function __construct( $config ) 
    {
		/**
		 * Store config items
		 *
		 * @see	/app/config.php
		 */		
        $this->config = $config;

		/**
		 * Init the Database layer
		 *
		 * @link	https://github.com/mikecao/sparrow
		 * @link	https://packagist.org/packages/unlight/sparrow
		 */
		$this->pdo = FALSE;
		$this->db = FALSE;
		if ( DB_USER != '' && DB_NAME != '' )
		{
			try {
				$this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->exec("SET NAMES 'utf8';");
				
				$this->db = new \Sparrow();
				$this->db->setDb($this->pdo);
			} catch( PDOException $e ) {
				echo '<strong>Impossibile to connect to database: please check the parameters provided in /app/config.php.</strong><br />'. $e->getMessage();
			}
		}


		/**
		 * Init the template engine
		 *
		 * @link	http://www.raintpl.com
		 * @link	https://github.com/rainphp/raintpl3/wiki
		 */
		$this->tpl = new \Rain\Tpl();
		$this->tpl->configure( array(
			"base_url"		=> BASE_URL,
			"tpl_ext"		=> "php",
			'php_enabled'	=> true,
			"tpl_dir"       => "ui/",
			"cache_dir"     => "app/cache/"
		));


		/**
		 * Init the session class
		 *
		 * @see	/app/libraries/Session.php
		 */		
		$this->sess = new \App\Libraries\Session();

	
		/**
		 * Init the Router
		 *
		 * @link	https://github.com/bramus/router
		 */
		$this->router = new \Bramus\Router\Router();
    }

}


/* EOF */
