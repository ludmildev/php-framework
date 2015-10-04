<?php
namespace Controllers;

class Profile extends \FW\DefaultController {
    
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
