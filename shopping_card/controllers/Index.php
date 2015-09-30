<?php
namespace Controllers;

use FW\DefaultController as DefaultController;

class Index extends DefaultController {
    
    public function index() {
        
        $view = $this->view;
        
        $view->appendToLayout('body', 'home.index');
        
        $view->display('layouts.default', array(
            'isLogged' => false
        ));
    }
}