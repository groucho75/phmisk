<?php 

namespace App\Libraries;

/**
 * Session class
 *
 * This class is a simple wrapper for php session management.
 * It helps to use "flash" vars: session data that live
 * only in next round (e.g. feedbacks and messages to user).
 *
 * @package     Phmisk
 * @subpackage  Libraries
 * @author      Alessandro Massasso <alo@eventualo.net>
 * @license     GPL
 * @link        https://github.com/groucho75/phmisk
 */
class Session
{

    /**
     * Start the session.
     * 
     * Init the php session, often regenerate the session id,
     * update/delete the flash msgs.
     */      
    public function start() 
    {
        if ( session_id() == '' ) session_start();
        
        if ( rand(1, 5) == 5 ) session_regenerate_id();
        
        if (isset($_SESSION['__flash__'])) 
        { 
            foreach($_SESSION['__flash__'] as $k=>$item) 
            { 
                if ( $item['age'] == 0 )
                {
                    $_SESSION['__flash__'][$k]['age'] = 1;
                }
                else if ( $item['age'] == 1 )
                {
                    unset( $_SESSION['__flash__'][$k] );
                }
            } 
        }
    }


    /**
     * Set the value of a session item
     * 
     * @param str   the item key
     * @param str   the new value 
     */           
    public function set( $key, $value ) 
    { 
        $_SESSION[$key] = $value;
    } 


    /**
     * Get the value of an item. If null the default
     * value will be returned.
     * 
     * @param str   the item key
     * @param str   a default value 
     * @return  mix the item value, or default
     */  
    public function get( $key, $default=NULL )
    { 
        if ( array_key_exists($key, $_SESSION) )
        {
            return $_SESSION[$key];
        } 
        else 
        {
             return $default; 
        } 
    }


    /**
     * Set the value of a flash session item.
     * 
     * @param str   the item key
     * @param str   the new value 
     */           
    public function setFlash( $key, $value ) 
    { 
        $_SESSION['__flash__'][$key] = array(
            'age' => 0,
            'value' => $value
        );
    } 

    /**
     * Get the value of a flash item. If null the default
     * value will be returned.
     * 
     * @param str   the item key
     * @param str   a default value 
     * @return  mix the item value, or default
     */      
    public function getFlash( $key, $default=NULL )
    { 
        if ( isset($_SESSION['__flash__']) && array_key_exists($key, $_SESSION['__flash__']) )
        {
            return $_SESSION['__flash__'][$key]['value'];
        } 
        else 
        {
             return $default; 
        } 
    }
    

    /**
     * Destroy the session, unset all data.
     * 
     * @link http://stackoverflow.com/questions/3948230/best-way-to-completely-destroy-a-session-even-if-the-browser-is-not-closed 
     */       
    public function destroy()
    {
        // Unset all of the session variables.
        session_unset();
        $_SESSION = array();
 
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Finally, destroy the session.
        session_destroy();
    }
}


/* EOF */
