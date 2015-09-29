<?php
namespace Models\BindingModels;

class Login
{
    private $username;
    private $password;

    function __construct(array $params)
    {
        $this->setPassword($params['password']);
        $this->setUsername($params['username']);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    private function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    private function setPassword($password)
    {
        $this->password = md5($password);
    }
}