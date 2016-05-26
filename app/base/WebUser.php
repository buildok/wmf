<?php
namespace app\base;

use app\base\AppException;

session_start();

/**
*   WebUser Class
*/
class WebUser {
    
    /**
    *check user status
    *@return boolean true if user authorized, else false
    */
    public static function isGuest()
    {
        return !(isset($_SESSION['identity']));
    }
    
    /**
    *open user session
    *@param mixed $params stored user data
    *@return void
    */
    public static function openSession($params)
    {
        $_SESSION['identity'] = $params;
    }
    
    /**
    *close user session
    *@return void
    */    
    public static function closeSession()
    {
        setcookie(session_name(), false, -1, '/');
        session_unset();
        session_destroy();
    }
    
    /**
    *get authorized user ID
    *@throw AppException if user ID not set
    *@return integer
    */
    public static function getID()
    {
        if(!isset($_SESSION['identity']['id'])) {
            
            throw new AppException('Session aborted');
        }
        
        return $_SESSION['identity']['id'];
    }
    
    /**
    *get language code for authorized user
    *@return string
    */
    public static function getLanguage()
    {
        return isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'en';
    }
    
    /**
    *set language code for authorized user
    *@param string $lang
    *@return void
    */
    public static function setLanguage($lang)
    {
        setcookie('lang', $lang, 0, '/');
    }
}