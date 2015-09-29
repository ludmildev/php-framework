<?php
namespace FW;

include 'Loader.php';

use FW\App as Application;
use FW\Loader as Loader;
use FW\Config as Config;
use FW\FrontController as FrontController;
use FW\Routers\DefaultRouter as DefaultRouter;
use FW\Routers\IRouter as IRouter;
use FW\Sessions as Sessions;
use Models\Users as Users;

class App {

    private static $_instance = null;
    private $_config = null;
    private $_router = null;
    private $_dbConnection = null;
    /**
     *
     * @var Sessions\ISession
     */
    private $_session = null;

    /**
     *
     * @var FrontController
     */
    private $_frontController = null;

    private function __construct()
	{
        set_exception_handler(array($this, '_exceptionHandler'));
        
        Loader::registerNamespace('FW', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
		
		$this->_config = Config::getInstance();
        
        if (empty($this->_config->getConfigFolder())) {
			$this->setConfigFolder('../config');
		}
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
        
        $_sess = $this->getConfig()->app['session'];
        
        if ($_sess['autostart'])
        {
            switch($_sess['type'])
            {
                case 'database':
                    $s = new Sessions\DBSession(
                        $_sess['dbConnection'], 
                        $_sess['name'], 
                        $_sess['dbTable'], 
                        $_sess['lifetime'], 
                        $_sess['path'], 
                        $_sess['domain'], 
                        $_sess['secure']
                    );
                    break;
                case 'native':
                    $s = new Sessions\NativeSession(
                        $_sess['name'], 
                        $_sess['lifetime'], 
                        $_sess['path'], 
                        $_sess['domain'], 
                        $_sess['secure']
                    );
                    break;
                default:
                    throw new \Exception('No Valid Session', 500);
            }
            
            $this->setSession($s);
        }
        
        $this->_frontController->dispatch();
	}
    
    public function setSession(Sessions\ISession $session) {
        $this->_session = $session;
    }
    /**
     * 
     * @return Sessions\ISession
     */
    public function getSession() {
        return $this->_session;
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
    
    public function _exceptionHandler(\Exception $ex)
    {        
        if ($this->_config && $this->_config->app['displayExceptions'] == true) {
            echo '<pre>' . print_r($ex, true) . '</pre>';
        } else {
            $this->displayError($ex->getCode());
        }
    }
    
    public function displayError($error)
    {
        try {
            $view = \FW\View::getInstance();
            $view->display('errors.' . $error);
        } catch (\Exception $exc) {
            \FW\Common::headerStatus($error);
            echo '<h1>' . $error . '</h1>';
            exit;
        }
    }
    
    public function getUsername()
    {
        return $this->_session->username;
    }

    public function isLogged()
    {
        return !empty($this->_session->username);
    }

    public function isAdmin()
    {
        return !empty($this->_session->isAdmin) ? (bool)$this->_session->isAdmin : false;
    }

    public function isEditor()
    {
        return !empty($this->_session->isEditor) ? (bool)$this->_session->isEditor : false;
    }

    public function isModerator()
    {
        return !empty($this->_session->isModerator) ? (bool)$this->_session->isModerator : false;
    }
    
    public function __destruct() {
        if (!empty($this->_session)) {
            $this->_session->saveSession();
        }
    }
}