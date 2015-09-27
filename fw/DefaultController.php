<?php
namespace FW;

use FW\App as App;
use FW\Config as Config;
use FW\InputData as InputData;

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

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();
    }
    
    public function jsonResponse(){
        
    }

}