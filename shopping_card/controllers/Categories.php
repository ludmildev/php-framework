<?php
namespace Controllers;

class Categories extends \FW\DefaultController {
    
    public function index()
    {
        $view = $this->view;

        $view->appendToLayout('body', 'categories');
        
        $categories = \Models\Categories::getAllCategories();
        $viewModel = new \Models\ViewModels\AllCategories($categories);
        
        $view->display('layouts.default', array(
            'categories' => $viewModel->getAll()
        ));
    }
}