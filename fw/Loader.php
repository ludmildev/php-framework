<?php

namespace FW;

final class Loader {
    
    private static $namespaces = array();
    
    private function __construct() {

    }
    
    public static function registerAutoLoad() {
        spl_autoload_register(function($class){
            self::loadClass($class);
        });
    }
    
    public static function loadClass($class)
    {
        foreach(self::$namespaces as $key => $value)
        {
            if (stripos($class, $key) === 0)
            {
                $file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $value, 0, strlen($key)).'.php');
                
                if ($file && is_readable($file)) {
                    include $file;
                } else {
                    //TODO
                    throw new \Exception('File Cannot be included: ' . $file);
                }
                break;
            }
        }
    }
    
    public static function registerNamespace($namespace, $path)
    {
        $_namespace = trim($namespace);
        
        if (strlen($_namespace) > 0) 
        {
            if (!$path) {
                throw new \Exception('Invalid path');
            }
            $_path = realpath($path);
            
            if ($_path && is_dir($_path) && is_readable($_path)) {
                self::$namespaces[$_namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                //TODO
                throw new \Exception('Namespace directory read error: '. $path);
            }
        } else {
            //TODO
            throw new \Exception('Invalid Namespace: ' . $namespace);
        }
    }
    
    public static function getNamespaces() {
        return self::$namespaces;
    }
    public static function removeNamespace($namespace) {
        unset(self::$namespaces[$namespace]);
    }
    public static function clearNamespaces() {
        self::$namespaces = array();
    }
}