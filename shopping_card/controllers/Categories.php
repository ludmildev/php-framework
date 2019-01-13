<?php
namespace Controllers;

class Categories extends \FW\DefaultController {
    
    public function index()
    {        
        $categories = \Models\Categories::getAllCategories();
        $viewModel = new \Models\ViewModels\AllCategories($categories);
        
        $this->view->appendToLayout('categories')->display('layout', array(
            'categories' => $viewModel->getAll()
        ));
    }
    
    public function show()
    {
        $products = \Models\Products::getById();
        
        $this->view->appendToLayout('products')->display('layout', array(
            'products' => $products
        ));
    }
}