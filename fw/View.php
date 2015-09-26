<?php
namespace FW;

use FW\View as View;
use FW\App as App;

class View {
    
    private static $_instance = null;
    private $_viewPath = null;
    private $viewDir = null;
    private $_data = array();
    
    private function __construct()
    {
        $this->_viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        
        if (empty($this->_viewPath)) {
            $this->_viewPath = realpath('../views/');
        }
    }
    
    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data)) {
            $this->_data = array_merge($this->_data, $data);
        }
        
        if ($returnAsString) {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }
    }
    
    private function _includeFile($file) 
    {
        if (empty($this->viewDir)) {
            $this->setViewDirectory($this->_viewPath);
        }
        
        $p = str_replace('.', DIRECTORY_SEPARATOR, $file);
        $fl = $this->viewDir . $p . $this->extention;
        
        if (file_exists($fl) && is_readable($fl))
        {
            ob_start();
            include $fl;
            return ob_get_clean();
        }
        else
            throw new \Exception('View ' . $file . ' cannot be included', 500);
        
        return null;
    }
    
    public function setViewDirectory($path)
    {
        $path = trim($path);
        
        if (!empty($path))
        {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            
            if (is_dir($path) && is_readable($path))
            {
                $this->viewDir = $path;
            } else {
                throw new \Exception('view path');
            }
        }
        else
            throw new \Exception('view path', 500);
    }
    
    public function __get($name) {
        return !empty($this->_data[$name]) ? $this->_data[$name] : null;
    }
    public function __set($name, $value) {
        $this->_data[$name] = $value;
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
