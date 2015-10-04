<?php
namespace Controllers;

class Profile extends \FW\DefaultController {
    
    function __construct() {
        parent::__construct();
        
        if (!$this->session->isLogged)  {
            $this->redirect('/');
            exit;
        }
    }

    public function index()
    {
        $view = $this->view;
        
        $view->appendToLayout('body', 'profile');
        
        $view->display('layouts.default');
    }
    
    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }
}
