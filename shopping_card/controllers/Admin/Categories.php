<?php
namespace Controllers\Admin;

class Categories extends \FW\DefaultController {
    
    public function index() 
    {
        $categories = \Models\Categories::getAllCategories();

        $this->view->changeLayout('admin')->appendToLayout('categories.index')->display('layout', array(
            'categories' => $categories
        ));
    }

    public function add() 
    {
        $name = \FW\InputData::getInstance()->post('category', 'string', '');

        if (empty($name)) {
            throw new \Exception('Invalid Data Provided', 200);
        }

        $result = \Models\Admin\Categories::add(new \Models\BindingModels\Admin\AddCategory(array(
            'name' => $name
        )));

        if ($result['success'] == 0) {
            throw new \Exception($result['message'], $result['code']);
        }

        $this->redirect('/admin/categories');
    }

    public function delete($params)
    {
        if (empty($params[0])) {
            throw new \Exception('Invalid Data Provided', 200);
        }

        $result = \Models\Admin\Categories::delete((int)$params[0]);

        if ($result['success'] == 0) {
            throw new \Exception($result['message'], $result['code']);
        }

        $this->redirect('/admin/categories');
    }
}