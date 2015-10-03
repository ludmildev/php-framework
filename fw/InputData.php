<?php

namespace FW;

use FW\InputData as InputData;
use FW\Common as Common;

class InputData {
    
    private static $_instance = null;
    private $_get = array();
    private $_post = null;
    private $_cookies = null;
    
    private function __construct()
    {
        $this->_cookies = $_COOKIE;
    }
    
    public function setPost($val) {
        if (is_array($val)) {
            $this->_post = $val;
        }
    }
    public function setGet($val) {
        if (is_array($val)) {
            $this->_get = $val;
        }
    }
    public function hasPost($name) {
        return array_key_exists($name, $this->_post);
    }
    public function hasGet($id = null) {
        return array_key_exists($id, $this->_get);
    }
    public function hasCookies($name) {
        return array_key_exists($name, $this->_cookies);
    }
    
    public function get($id, $cast = null, $defaut = null)
    {
        if ($this->hasGet($id))
        {
            if (!empty($cast)) {
                return Common::normalize($this->_get[$id], $cast);
            }
            return $this->_get[$id];
        }
        return $defaut;
    }
    public function post($name, $cast = null, $defaut = null)
    {
        if ($this->hasPost($name))
        {
            if (!empty($cast)) {
                return Common::normalize($this->_post[$name], $cast);
            }
            return $this->_post[$name];
        }
        return $defaut;
    }
    public function cookies($name, $cast = null, $defaut = null)
    {
        if ($this->hasCookies($name))
        {
            if (!empty($cast)) {
                return Common::normalize($this->_cookies[$name], $cast);
            }
            return $this->_cookies[$name];
        }
        return $defaut;
    }
    
    /**
     * 
     * @return InputData
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new InputData();
        }
        
        return self::$_instance;
    }
}
