<?php
namespace Models;

class Users  {
    
    public static function login(\Models\BindingModels\Login $model)
    {
        $db = new \FW\Db\SimpleDb();

        $result = $db->prepare("
            SELECT 
                id, username, isAdmin, isEditor, isModerator
            FROM users
            WHERE 1 
                AND username = ? 
                AND password = ?",
            [$model->getUsername(), $model->getPassword()]
        )->execute()->fetchRowAssoc();
        
        if (empty($result)) {
            return ['success' => 0, 'message' => 'Invalid Username or password provided!', 'code' => 400];
        }
        
        $session = \FW\App::getInstance()->getSession();

        $session->userId = $result['id'];
        $session->username = $result['username'];
        $session->isAdmin = $result['isAdmin'];
        $session->isEditor = $result['isEditor'];
        $session->isModerator = $result['isModerator'];
        $session->isLogged = true;
        
        $session->saveSession();
        
        return ['success' => 1, 'message' => ''];
    }
    
    public static function register(\Models\BindingModels\Register $model)
    {
        $db = new \FW\Db\SimpleDb();
        
        $result = $db->prepare("
            SELECT id, username
            FROM users
            WHERE 1 
                AND username = ? ",
            [$model->getUsername()]
        )->execute()->fetchRowAssoc();
        
        if (!empty($result)) {
            return ['success' => 0, 'message' => 'Username already registered!', 'code' => 400];
        }
        
        $defaultCash = \FW\App::getInstance()->getConfig()->app['defaultCash'];
        
        $db->prepare("
            INSERT INTO users (
                username, password, cash
            ) VALUES (
                ?, ?, ?
            )", 
            [$model->getUsername(), $model->getPassword(), $defaultCash]
        )->execute();

        return ['success' => 1, 'message' => ''];
    }
}
