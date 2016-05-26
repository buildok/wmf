<?php
namespace app\models;

use app\base\Model;
use app\base\WebUser;

/**
*   Lang Class
*/
class Lang extends Model
{
    /**
    *get string with translate user language
    *@return string
    */
    public static function T($str)
    {
        $code = WebUser::getLanguage();
        
        if($code == 'en') {
            
            return $str;
        } else {
            if($rec = self::findOne(['en' => $str])) {
                
                return ($rec->$code) ? $rec->$code : $rec->en;
            } else {
                
                return $str;
            }
        }
    }
}