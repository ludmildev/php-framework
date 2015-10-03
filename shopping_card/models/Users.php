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
}
