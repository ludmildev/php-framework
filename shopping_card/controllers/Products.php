<?php

namespace Controllers;

class Products extends \FW\DefaultController {
    
    public function index() {
        
        $products = \Models\Products::getAll($this->input->get(0), $this->input->get(1));
        
        $this->view->appendToLayout('products')->display('layout', array(
            'products' => $products
        ));
    }
}
