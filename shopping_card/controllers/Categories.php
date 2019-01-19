<?php
namespace Controllers;

use FW\App;

class Categories extends \FW\DefaultController {
    
    public function index($params)
    {
        switch ($params[0]) {
            case 'index':
                break;
            case 'show':
                $this->show();
                return;
            default:
                App::getInstance()->displayError(404, 'Page not found!');
        }

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