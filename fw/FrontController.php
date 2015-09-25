<?php
namespace FW;

use FW\FrontController as FrontController;
use FW\App as App;
use FW\Routers\DefaultRouter as DefaultRouter;

class FrontController {
    
    private static $_instance = null;
    
    private function __construct() {
    
    }
    
    public function dispatch() {
        
        $router = new DefaultRouter();
        
        $router->parse();
        
        $controller = $router->getController();
        $method = $router->getMethod();
        
        if ($controller == null) {
            $controller = $this->getDefaultController();
        }
        if ($method == null) {
            $method = $this->getDefaultMethod();
        }
        
        echo $controller . ' - ' . $method;
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