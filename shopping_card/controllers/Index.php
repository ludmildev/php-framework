<?php

namespace Controllers;

class Index {
    
    public function index() {
        
        $view = \FW\View::getInstance();
        
        $view->display('index');
    }
}