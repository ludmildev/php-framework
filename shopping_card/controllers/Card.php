<?php
namespace Controllers;

class Card extends \FW\DefaultController {
    
    public function index()
    {
        $view = $this->view;
        
        $view->appendToLayout('body', 'card.index');
        
        $view->display('layouts.default');
    }
}
