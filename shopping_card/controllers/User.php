<?php
namespace Controllers;

use FW\InputData as InputData;

class User extends \FW\DefaultController {

    public function index() {
        $this->redirect('/');
        exit;
    }

    public function login($_username = null, $_password = null)
    {
        $username = !empty($_username) ? $_username : InputData::getInstance()->post('username', 'string', '');
        $password = !empty($_password) ? $_password : InputData::getInstance()->post('password', 'string', '');

        $result = \Models\Users::login(new \Models\BindingModels\Login(array(
            'username' => $username,
            'password' => $password
        )));

        if ($result['success'] == 0) {
            throw new \Exception($result['message'], $result['code']);
        }

        $this->redirect('/');
    }

    public function register()
    {
        $username = InputData::getInstance()->post('username', 'string', '');
        $password = InputData::getInstance()->post('password', 'string', '');
        $confirm = InputData::getInstance()->post('confirm', 'string', '');

        $result = \Models\Users::register(new \Models\BindingModels\Register(array(
            'username' => $username,
            'password' => $password,
            'confirm' => $confirm
        )));

        if ($result['success'] == 0) {
            throw new \Exception($result['message'], $result['code']);
        }

        $this->login($username, $password);
    }
}
