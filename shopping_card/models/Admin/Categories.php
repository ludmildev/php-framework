<?php
namespace Models\Admin;

class Categories {
    
    public static function getAllCategories()
    {
        $db = new \FW\Db\SimpleDb();
        
        $categories = $db->prepare("
        SELECT id, name
        FROM categories")->execute()->fetchAllAssoc();
        
        return $categories;
    }

    public static function add(\Models\BindingModels\Admin\AddCategory $model)
    {
        $db = new \FW\Db\SimpleDb();
        
        $db->prepare("INSERT INTO `categories` (`name`) VALUES (?)", 
        [$model->getName()])->execute();

        return ['success' => 1, 'message' => ''];
    }

    public static function delete($id)
    {
        $db = new \FW\Db\SimpleDb();
        
        $db->prepare("DELETE FROM `categories` WHERE `id` = (?)", [$id])->execute();

        return ['success' => 1, 'message' => ''];
    }
}
