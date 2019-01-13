<?php
namespace Controllers;

use FW\DefaultController as DefaultController;

class Index extends DefaultController {
    
    public function index()
    {   
        $this->view->test = 'test';
        
        $this->view->appendToLayout('home.index')->display('layout');
    }
}