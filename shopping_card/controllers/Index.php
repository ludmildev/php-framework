<?php

namespace Controllers;

class Index {
    
    public function index() {
        
        $view = \FW\View::getInstance();
        
        $view->appendToLayout('body', 'home.index');
        
        $view->display('layouts.default');
    }
}