<?php
namespace Controllers;

class Signin extends \FW\DefaultController {
    
    public function __construct() {
        parent::__construct();
        
        if (!empty($this->session->userId)) {
            $this->redirect('/');
            exit;
        }
    }
    
    public function index()
    {
        $this->view->appendToLayout('user.login')->display('layout');
    }
}
