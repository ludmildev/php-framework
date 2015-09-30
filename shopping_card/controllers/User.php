<?php

use FW\InputData as InputData;

class User extends \FW\DefaultController {
    
    public function login()
    {
        $username = InputData::getInstance()->post('username', 'string', '');
        $password = InputData::getInstance()->post('password', 'string', '');
        
        $bindingModel = \Models\BindingModels\Login($username, $password);
        
        $result = \Models\Users::login($bindingModel);
        
        if ($result['success'] == 0) {
            throw new \Exception('Invalid Username or password provided!', $result['code']);
        }
        
        $this->redirect('/');
    }
}
