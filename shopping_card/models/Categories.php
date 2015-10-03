<?php
namespace Models;

class Categories {
    
    public static function getAllCategories()
    {
        $db = new \FW\Db\SimpleDb();
        
        $categories = $db->prepare("
        SELECT id, name
        FROM categories")->execute()->fetchAllAssoc();
        
        return $categories;
    }
}
