<?php
namespace Controllers;

class Signin extends \FW\DefaultController {
    
    public function index()
    {
        $view = $this->view;
        
        $view->appendToLayout('body', 'user.login');
        
        $view->display('layouts.default', array('isLogged' => 'da'));
    }
}
