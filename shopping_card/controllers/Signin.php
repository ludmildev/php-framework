<?php
namespace Controllers;

class Signin extends \FW\DefaultController {
    
    public function __construct() {
        parent::__construct();
        
        if (!empty($this->session->getSessionId())) {
            $this->redirect('/');
            exit;
        }
    }
    
    public function index()
    {
        $view = $this->view;
        
        $view->appendToLayout('body', 'user.login');
        
        $view->display('layouts.default', array('isLogged' => 'da'));
    }
}
