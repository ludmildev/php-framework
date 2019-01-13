<?php
namespace Controllers\Admin;

class Index extends \FW\DefaultController {
    
    public function index() 
    {
        $this->view->appendToLayout('admin.index')->display('layout', array(

        ));
    }

    public function new() {

        $this->view->appendToLayout('admin.index')->display('layout', array(

        ));
    }
}