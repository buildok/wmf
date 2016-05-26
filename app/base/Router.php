<?php
namespace app\base;

/**
*  Router Class 
*/
class Router 
{
    /**
    *@var string[] array of routing rules
    */
    private $routes;
    
    /**
    @var string[] array of default controller/action
    */
    private $defaultRoute;
 
    public function __construct($routes, $defaultRoute) 
    {
        $this->routes = $routes;
        $this->defaultRoute = $defaultRoute;
    }

    /**
    *get request URL
    *@return string|boolean request URL or false, if empty
    */
    public function getURI() 
    {
        if(!empty($_SERVER['REQUEST_URI'])) {
            
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        
        return false;
    }

    /*
    *launch URL parser and call controller action
    *@return void
    */
    public function run()
    {
        if($uri = $this->getURI()) {
            
            foreach($this->routes as $pattern => $route) {
                if(preg_match($pattern, $uri, $matches)) {
                    $controller = ucfirst($matches['controller']) . 'Controller';
                    $action = $matches['action'];
                    
                    $filename = implode(DIRECTORY_SEPARATOR, [ROOT, 'app', 'controllers', $controller]) . '.php';
                    if(file_exists($filename)) {
                        $controller_ns = 'app\controllers\\' . $controller;

                        if(method_exists($controller_ns, $action)) {
                            $controllerObj = new $controller_ns;
                            call_user_func_array([$controllerObj, $action], []);
                            return;
                        }
                    }
                }
            }

            header("HTTP/1.0 404 Not Found");
        } else {
            $controllerObj = new $this->defaultRoute['controller'];
            call_user_func_array([$controllerObj, $this->defaultRoute['action']], []);
        }
            
        return;
    }
}