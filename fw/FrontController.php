<?php
namespace FW;

use FW\App as App;
use FW\FrontController as FrontController;
use FW\Routers\IRouter as IRouter;

class FrontController {
    
    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    private $router = null;

    function getRouter() {
        return $this->router;
    }
    function setRouter(IRouter $router) {
        $this->router = $router;
    }

    private function __construct() {
    
    }
    
    public function dispatch()
    {
        if ($this->router == null) {
            throw new \Exception('No Valid Router Found', 500);
        }
        
        $_uri = $this->router->getURI();
        $routes = App::getInstance()->getConfig()->routes;
        $_rc = null;
        
        if (is_array($routes) && count($routes) > 0)
        {
            foreach ($routes as $key => $val)
            {
                if (stripos($_uri, $key) === 0 && ($_uri == $key || stripos($_uri, $key.'/') === 0) && $val['namespace'])
                {
                    $this->namespace = $val['namespace'];
                    $_uri = substr($_uri, strlen($key)+1);
                    $_rc = $val;
                    break;
                }
            }
        } 
        else {
            //TODO
            throw new \Exception('Default Route missing', 500);
        }
        
        if ($this->namespace == null && $routes['*']['namespace']) {
            $this->namespace = $routes['*']['namespace'];
            $_rc = $routes['*'];
        }
        elseif ($this->namespace == null && !$routes['*']['namespace']) {
            throw new \Exception('Default Route missing', 500);
        }
        
        $_params = explode('/', $_uri);
        
        if ($_params[0])
        {
            $this->controller = strtolower($_params[0]);
            
            if (!empty($_params[1]))
            {
                $this->method = strtolower($_params[1]);
                unset($_params[0], $_params[1]);
                
                $this->params = array_values($_params);
            }
            else {
                $this->method = 'index';
            }
        }
        else
        {
            $this->controller = 'index';
            $this->method = 'index';
        }
        
        if (is_array($_rc) && !empty($_rc['controllers']))
        {
            if (!empty($_rc['controllers'][$this->controller]['methods'][$this->method])) {
                $this->method = strtolower($_rc['controllers'][$this->controller]['methods'][$this->method]);
            }

            if (!empty($_rc['controllers'][$this->controller]['to']))
                $this->controller = strtolower($_rc['controllers'][$this->controller]['to']);
        }
        
        $controller = $this->namespace . '\\' . ucfirst($this->controller);
        $newController = new $controller();
        
        $newController->{$this->method}();
    }
    
    public function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        
        if ($controller) {
            return strtolower($controller);
        }
        return 'index';
    }
    public function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        
        if ($method) {
            return strtolower($method);
        }
        return 'index';
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