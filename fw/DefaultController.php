<?php
namespace FW;

use FW\App as App;
use FW\Config as Config;
use FW\InputData as InputData;
use FW\Sessions\ISession as ISession;

class DefaultController {
    
    /**
     *
     * @var App 
     */
    public $app;
    /**
     *
     * @var View
     */
    public $view;
    /**
     *
     * @var Config 
     */
    public $config;
    /**
     *
     * @var InputData 
     */
    public $input;
    
    /**
     * 
     * @var ISession
     */
    protected $session;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();
        $this->session = $this->app->getSession();
        
        $this->view->isLogged = empty($this->session->getSessionId()) ? false : true;
    }
    
    public function jsonResponse(){
        
    }
    
    protected function redirect($uri) {
        header("Location: {$uri}");
    }

}