<?php

namespace Controllers;

class Products {
    
    
    public function index() {
        
        $view = $this->view;
        
        $view->appendToLayout('body', 'products');
        
        $view->display('layouts.default');
    }
}
