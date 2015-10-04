<?php
namespace Controllers;

class Cart extends \FW\DefaultController {
    
    public function index()
    {
        $view = $this->view;
        
        $view->appendToLayout('body', 'cart.index');
        
        $view->display('layouts.default');
    }
}
