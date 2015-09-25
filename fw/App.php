<?php
namespace FW;

include 'Loader.php';

use FW\App as Application;
use FW\Loader as Loader;
use FW\Config as Config;
use FW\FrontController as FrontController;

class App {

    private static $_instance = null;
    private $_config = null;

    /**
     *
     * @var FrontController
     */
    private $_frontController = null;

    private function __construct()
	{
        Loader::registerNamespace('FW', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
		
		$this->_config = Config::getInstance();
    }

	public function setConfigFolder($path) {
		$this->_config->setConfigFolder($path);
	}
	public function getConfigFolder() {
		return $this->_config->_configFolder;
	}
	
	/**
	*
	* @return Config
	*/
	public function getConfig() {
		return $this->_config;
	}
	
    public function run()
    {
        if ($this->_config->getConfigFolder() == null) {
			$this->setConfigFolder('../config');
		}
        
        $this->_frontController = FrontController::getInstance();
        $this->_frontController->dispatch();
	}

	/**
	*
	* @return App
	*/
	public static function getInstance()
	{
		if (self::$_instance == null) {
			self::$_instance = new Application();
		}

		return self::$_instance;
	}
}