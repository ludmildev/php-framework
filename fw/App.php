<?php
namespace FW;

include 'Loader.php';

use FW\App as Application;
use FW\Loader as Loader;

class App {

	public static $_instance = null;

    private function __construct() {
        Loader::registerNamespace('FW', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
    }

    public function run() {
        
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