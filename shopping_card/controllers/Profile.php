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
        $this->view->appendToLayout('profile')->display('layout');
    }
    
    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }
}
