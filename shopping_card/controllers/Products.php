<?php

namespace Controllers;

class Products extends \FW\DefaultController {
    
    
    public function index() {
        
        $view = $this->view;
        
        $view->appendToLayout('body', 'products');
        
        $view->display('layouts.default');
    }
}
