<?php

namespace FW\Routers;

class DefaultRouter {
    
    private $_controller = null;
    private $_method = null;
    private $_params = array();
    
    public function parse()
    {
        $uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])+1);
        
        $_params = explode('/', $uri);
        
        if ($_params[0])
        {
            $this->_controller = ucfirst($_params[0]);
            
            if ($_params[1])
            {
                $this->_method = $_params[1];
                unset($_params[0], $_params[1]);
                
                $this->_params = array_values($_params);
            }
        }
    }
    
    public function getController() {
        return $this->_controller;
    }
    public function getMethod() {
        return $this->_method;
    }
    public function getGet() {
        return $this->_params;
    }
}