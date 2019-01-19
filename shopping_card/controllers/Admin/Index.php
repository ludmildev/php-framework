<?php
namespace Controllers\Admin;

class Index extends \FW\DefaultController {

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->isLogged) {
            $this->redirect('/signin');
        }
    }

    public function index() 
    {
        $this->view->changeLayout('admin')->appendToLayout('index')->display('layout', array(

        ));
    }

    public function tralala() {

        $this->view->changeLayout('admin')->appendToLayout('index')->display('layout', array(

        ));
    }
}