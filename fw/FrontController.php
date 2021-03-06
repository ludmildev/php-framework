<?php
namespace FW;

use FW\App as App;
use FW\Routers\IRouter as IRouter;
use FW\InputData as InputData;

class FrontController {
    
    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    private $params = null;
    private $_requestMethod = null;
    
    /**
     *
     * @var IRouter
     */
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
        
        $this->_requestMethod = strtolower($this->router->getRequestMethod());

        if ($this->_requestMethod != 'get')
        {
            $token = $this->router->getPost()['_token'];
            $tokenOblect = Token::init();
            
            if (!$tokenOblect->validate($token)) {
                throw new \Exception('Invalid token!', 400);
            }
            if (!empty($this->router->getPost()['_method'])) {
                $this->_requestMethod = strtolower($this->router->getPost()['_method']);
            }
        }
        
        $_uri = $this->router->getURI();
        $routes = App::getInstance()->getConfig()->routes;
        $_defaultConfigRoutes = null;
        
        if (is_array($routes) && count($routes) > 0)
        {
            foreach ($routes as $key => $val)
            {
                if (stripos($_uri, $key) === 0 && ($_uri == $key || stripos($_uri, $key.'/') === 0) && $val['namespace'])
                {
                    $this->namespace = $val['namespace'];
                    $_uri = substr($_uri, strlen($key)+1);
                    $_defaultConfigRoutes = $val;
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
            $_defaultConfigRoutes = $routes['*'];
        }
        elseif ($this->namespace == null && !$routes['*']['namespace']) {
            throw new \Exception('Default Route missing', 500);
        }
        
        $_params = explode('/', $_uri);
        
        $input = InputData::getInstance();
        
        if ($_params[0])
        {
            $this->controller = strtolower($_params[0]);
            
            if (!empty($_params[1]))
            {
                $this->method = strtolower($_params[1]);
                unset($_params[0], $_params[1]);
                $input->setGet(array_values($_params));
                $this->params = array_values($_params);
            }
            else {
                $this->method = 'index';
            }
        }
        else
        {
            $this->controller = 'Index';
            $this->method = 'index';
        }

        if (is_array($_defaultConfigRoutes) && !empty($_defaultConfigRoutes['controllers']))
        {
            if (empty($_defaultConfigRoutes['controllers'][strtolower($this->controller)])) {
                App::getInstance()->displayError(404, 'Page not found');
                exit;
            }
            if (!empty($_defaultConfigRoutes['controllers'][$this->controller]['to']))
                $this->controller = strtolower($_defaultConfigRoutes['controllers'][$this->controller]['to']);

            if (!empty($_defaultConfigRoutes['controllers'][$this->controller]['methods']['*'])) {
                if (!empty($this->params)) {
                    array_unshift($this->params, $this->method);
                } else {
                    $this->params[] = $this->method;
                }
                $this->method = strtolower($_defaultConfigRoutes['controllers'][$this->controller]['methods']['*']);
            }
            else if (!empty($_defaultConfigRoutes['controllers'][$this->controller]['methods'][$this->method])) {
                $this->method = strtolower($_defaultConfigRoutes['controllers'][$this->controller]['methods'][$this->method]);
            }
        }
        $input->setPost($this->router->getPost());
        
        $controller = $this->namespace . '\\' . ucfirst($this->controller);
        $newController = new $controller();
        $methodVar = array($newController, $this->method);
        
        if (is_callable($methodVar)) {
            $newController->{$this->method}($this->params);
        } else {
            App::getInstance()->displayError(404, 'Page not found!');
            exit;
        }
        
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