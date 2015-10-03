<?php

namespace Controllers;

class Products extends \FW\DefaultController {
    
    
    public function all() {
        
        $view = $this->view;
        
        $products = \Models\Products::getAll($this->input->get(0), $this->input->get(1));
        
        $view->appendToLayout('body', 'products');
        
        $view->display('layouts.default', array(
            'products' => $products
        ));
    }
}
