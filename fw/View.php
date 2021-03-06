<?php
namespace FW;

use FW\App as App;

class View {
    
    private static $_instance = null;
    private $___viewPath = null;
    private $___viewDir = null;
    private $_viewData = array();
    private $___extention = '.php';

    private $___layout = '';
    private $___layoutParts = array();
    private $___layoutData = array();
    
    private function __construct()
    {
        $this->___viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        $this->___layout = App::getInstance()->getConfig()->app['default_layout'];
        
        if (empty($this->___viewPath)) {
            $this->___viewPath = realpath('../views/');
        }
    }
    
    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->_viewData = array_merge($this->_viewData, $data);
        }
        
        if (count($this->___layoutParts) > 0)
        {
            foreach ($this->___layoutParts as $k => $val)
            {
                $r = $this->_includeFile($val);
                
                if (!empty($r)) {
                    $this->___layoutData[$k] = $r;
                }
            }
        }
        
        if ($returnAsString) {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }
    }
    
    public function changeLayout($layout) {
        if (!empty($layout)) {
            $this->___layout = $layout;
        } else {
            throw new \Exception('Invalid Layout', 500);
        }

        return self::$_instance;
    }

    public function appendToLayout($template, $key = 'body')
    {
        if (!empty($key) && !empty($template)) {
            $this->___layoutParts[$key] = $template;
        } else {
            throw new \Exception('Invalid Layout', 500);
        }

        return self::$_instance;
    }
    
    public function getLayoutData($name) {
        return $this->___layoutData[$name];
    }

    private function _includeFile($file) 
    {
        if (empty($this->___viewDir)) {
            $this->setViewDirectory($this->___viewPath);
        }

        if (empty($this->___layout)) {
            throw new \Exception('Layout not found', 500);
        }
        
        $___fl = $this->___viewDir . $this->___layout . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extention;

        if (file_exists($___fl) && is_readable($___fl))
        {
            ob_start();
            include $___fl;
            return ob_get_clean();
        }
        else
            throw new \Exception('View ' . $file . ' cannot be included', 500);
    }
    
    public function setViewDirectory($path)
    {
        $path = trim($path);
        
        if (!empty($path))
        {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            
            if (is_dir($path) && is_readable($path))
            {
                $this->___viewDir = $path;
            } else {
                throw new \Exception('view path');
            }
        }
        else
            throw new \Exception('view path', 500);
    }
    
    public function __get($name) {
        return !empty($this->_viewData[$name]) ? $this->_viewData[$name] : null;
    }
    public function __set($name, $value) {
        $this->_viewData[$name] = $value;
    }
    
    /**
     * 
     * @return View
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new View();
        }
        
        return self::$_instance;
    }
}
