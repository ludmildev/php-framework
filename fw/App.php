<?php
namespace FW;

include 'Loader.php';

use FW\App as Application;
use FW\Loader as Loader;
use FW\Config as Config;

class App {

	private static $_instance = null;
	private $_config = null;

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
	public function getConfig() {
		return $this->_config;
	}
	
    public function run() {
        if ($this->_config->getConfigFolder() == null) {
			$this->setConfigFolder('../config');
		}
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