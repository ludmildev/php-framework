<?php
namespace Controllers;

class Cart extends \FW\DefaultController {
    
    function __construct() {
        parent::__construct();
        
        if (!$this->session->isLogged)  {
            $this->redirect('/');
            exit;
        }
    }
    
    public function index()
    {   
        $products = $this->session->cart;

        $this->view->appendToLayout('cart.index')->display('layout', array(
            'products' => $products
        ));
    }
    
    public function add()
    {
        $productId = \FW\InputData::getInstance()->get(0);
        
        if (!$productId) {
            throw new \Exception('Invalid product details');
        }

        \Models\Card::add($productId);
    }
    public function remove()
    {
        $productId = \FW\InputData::getInstance()->get(0);
        
        if (!$productId) {
            throw new \Exception('Invalid product details');
        }

        \Models\Card::remove($productId);
    }
    
}
