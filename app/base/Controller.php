<?php
namespace app\base;

use app\base\View;

/**
*  Controller Class 
*/

class Controller
{
    /**
    *@var string[] $request array of request parameters
    */
    private $request;
    
    /**
    *@var string $layout page common template
    */
    public $layout = 'layouts/main';
    
    /**
    *sets $request to a new value
    */
    public function __construct()
    {
        $this->request['post'] = $_POST;        
        $this->request['get'] = $_GET;
        
        $this->view = new View();
    }
    
    /**
    *check the type of request
    *@return boolean true if ajax, else false
    */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') : false;
    }
    
    /**
    *value from $request
    *@param string $type type of request get|post
    *@param string $param parameter name
    *@return string|string[]|NULL value from request or NULL, if parameter not set
    */
    private function requestParam($type, $param)
    {
        if(isset($this->request[$type][$param])) {
            $ret = $this->request[$type][$param];
            
            return is_array($ret) ? $ret : htmlspecialchars(trim($ret));
        }
        
        return  NULL;
    }
    
    /**
    *@param string $param parameter name
    *@return string|string[]|NULL value from post request or NULL, if parameter not set
    */
    protected function post($param)
    {        
        return  $this->requestParam('post', $param);
    }
    
    /**
    *@param string $param parameter name
    *@return string|string[]|NULL value from get request or NULL, if parameter not set
    */
    protected function get($param)
    {
        return  $this->requestParam('get', $param);    
    }
    
    /**
    *redirect to $pattern
    *@param string $pattern controller/action
    *@return void
    */
    public function redirect($pattern)
    {
        header('Location: '.$pattern);
    }
    
    /**
    *rendering view
    *@param string $template name of page template
    *@param string[] $params data for the page template
    *@return void
    */
    public function render($template, $params = [])
    {
        $view = new View();
            
        return $view->render($this->layout, $template, $params);
    }
    
    /**
    *default action
    */
    public function index()
    {
        echo 'controller/index';
        return;
    }
}
