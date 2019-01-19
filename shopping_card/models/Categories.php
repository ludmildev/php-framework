<?php
namespace Models;

class Categories {
    
    public static function getAllCategories()
    {
        $db = new \FW\Db\SimpleDb();
        
        return $db->prepare("SELECT id, name FROM categories")->execute()->fetchAllAssoc();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getCategoryByID($id)
    {
        $db = new \FW\Db\SimpleDb();

        return $db->prepare("SELECT id, name FROM categories WHERE id = ?", [(int)$id])->execute()->fetchAllAssoc();
    }
}
