<?php
namespace app;

/**
*   Autoloader Class
*/
class Autoloader
{
    /**
    *load require file of used class
    *@param string $file classname
    *@return string require file if exist, else error message
    */
    public static function autoload($file)
    {
        $file = DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $filepath = ROOT . $file . '.php';

        if(file_exists($filepath)) {
            
            require_once($filepath);
        } else {
            
            echo 'Autoloader error: <b>' . $filepath . '</b> not found';
        }
    }
}
  
spl_autoload_register(__NAMESPACE__ . '\Autoloader::autoload');
