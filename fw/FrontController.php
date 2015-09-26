<?php
namespace FW;

use FW\FrontController as FrontController;
use FW\App as App;
use FW\Routers\DefaultRouter as DefaultRouter;

class FrontController {
    
    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;


    private function __construct() {
    
    }
    
    public function dispatch()
    {
        
        $router = new DefaultRouter();
        
        $_uri = $router->getURI();
        
        $routes = App::getInstance()->getConfig()->routes;
        
        if (is_array($routes) && count($routes) > 0)
        {
            foreach ($routes as $key => $val)
            {
                if (stripos($_uri, $key) === 0 && ($_uri == $key || stripos($_uri, $key.'/') === 0) && $val['namespace'])
                {
                    $this->namespace = $val['namespace'];
                    break;
                }
            }
            echo $this->namespace;
        } 
        else {
            //TODO
            throw new \Exception('Default Route missing', 500);
        }
        
        if ($this->namespace == null && $routes['*']['namespace']) {
            $this->namespace = $routes['*']['namespace'];
        }
        elseif ($this->namespace == null && !$routes['*']['namespace']) {
            throw new \Exception('Default Route missing', 500);
        }
    }
    
    public function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        
        if ($controller) {
            return $controller;
        }
        return 'Index';
    }
    public function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        
        if ($method) {
            return $method;
        }
        return 'Index';
    }
    
    /**
     * 
     * @return FrontController
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        
        return self::$_instance;
    }
}