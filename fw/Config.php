<?php
namespace FW;

use FW\Config as Config;

class Config {
    
    private static $_instance = null;
    private $_configFolder = null;
    private $_configArray = array();
    
    private function __construct() {
        
    }
    
	public function getConfigFolder() {
		return $this->_configFolder;
	}
	
    public function setConfigFolder($configFolder)
    {
        if (!$configFolder) {
            throw new \Exception('Empty config folder path');
        }
        
        $_configFolder = realpath($configFolder);
        
        if ($configFolder != false && is_dir($_configFolder) && is_readable($_configFolder))
        {
            $this->_configArray = array();
            $this->_configFolder = $_configFolder . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception('Config directory read error: ' . $configFolder);
        }
    }
    
    public function includeConfigFile($path)
    {
        if (!$path) {
            //TODO
            throw new \Exception;
        }
        
        $_file = realpath($path);
        
        if ($_file != false && is_file($_file) && is_readable($_file))
        {
            $_basename = explode('.php', basename($_file))[0];
            
            $this->_configArray[$_basename] = include $_file;;
        } else {
            //TODO
            throw new \Exception('Config file read error : ' . $path);
        }
    }
    
    public function __get($name)
    {
        if (!isset($this->_configArray[$name])) {
            $this->includeConfigFile($this->_configFolder . $name . '.php');
        }
        
        if (array_key_exists($name, $this->_configArray)) {
            return $this->_configArray[$name];
        }
        return null;
    }
    
    /**
     * 
     * @return Config
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Config();
        }
        
        return self::$_instance;
    }
}