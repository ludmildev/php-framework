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
        
        $this->view->isLogged = $this->session->isLogged;
        
        if ($this->session->isLogged)
        {
            $this->view->id = $this->session->id;
            $this->view->username = $this->session->username;
            $this->view->isAdmin = $this->session->isAdmin;
            $this->view->isEditor = $this->session->isEditor;
            $this->view->isModerator = $this->session->isModerator;
        }
    }
    
    public function jsonResponse(){
        
    }
    
    protected function redirect($uri) {
        header("Location: {$uri}");
    }

}