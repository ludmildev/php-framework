<?php
namespace FW;

include 'Loader.php';

use FW\App as Application;
use FW\Loader as Loader;
use FW\Config as Config;
use FW\FrontController as FrontController;
use FW\Routers\DefaultRouter as DefaultRouter;
use FW\Routers\IRouter as IRouter;

class App {

    private static $_instance = null;
    private $_config = null;
    private $_router = null;
    private $_dbConnection = null;

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
		return $this->_config->getConfigFolder();
	}
	function getRouter() {
        return $this->_router;
    }

    function setRouter($router) {
        $this->_router = $router;
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
        if (empty($this->getConfigFolder())) {
			$this->setConfigFolder('../config');
		}
        
        $this->_frontController = FrontController::getInstance();
        
        if ($this->_router instanceof IRouter) {
            $this->_frontController->setRouter($this->_router);
        }
        else
        {
            switch ($this->_router)
            {
                case 'jsonRPC':
                case 'cli':
                default :
                    $this->_frontController->setRouter(new DefaultRouter());
                    break;
            }
        }
        $this->_frontController->dispatch();
	}
    
    public function getConnection($connectionType = 'default')
    {
        if (empty($connectionType)) {
            throw new \Exception('No identification connection provided.', 500);
        }
        if (!empty($this->_dbConnection[$connectionType]))
            return $this->_dbConnection[$connectionType];
        
        $conf = $this->getConfig()->database;
        
        if (empty($conf[$connectionType])) {
            throw new \Exception('No valid identification connection provided.', 500);
        }
        
        $connection = $conf[$connectionType];
        
        $dbh = new \PDO($connection['url'], $connection['username'], $connection['pass'], $connection['pdo_options']);
        
        $this->_dbConnection[$connectionType] = $dbh;
        
        return $dbh;
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