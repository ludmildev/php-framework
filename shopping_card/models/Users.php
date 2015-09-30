<?php
namespace Models;

class Users {
    
    public static function login(\Models\BindingModels\Login $model)
    {
        $result = $this->db->prepare("
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

        $this->session->userId = $result['id'];
        $this->session->username = $result['username'];
        $this->session->isAdmin = $result['isAdmin'];
        $this->session->isEditor = $result['isEditor'];
        $this->session->isModerator = $result['isModerator'];
        
        return ['success' => 1, 'message' => ''];
    }
}
