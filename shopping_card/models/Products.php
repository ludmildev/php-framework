<?php
namespace Models;

class Products {
    
    public static function getAll($start = 0, $end = 1)
    {   
        $skip = $start < 2 ? 0 : $start;
        $take = ($end < 1 ? 1 : $end) - $skip;
        
        $db = new \FW\Db\SimpleDb();
        
        $products = $db->prepare("
        SELECT p.id, p.name, p.description, p.price, p.quantity
        FROM products p
        JOIN products_categories pc
            ON p.id = pc.productId
        JOIN categories c
            ON pc.categoryId = c.id
        WHERE 1
            AND p.quantity > 0
        ORDER BY p.id
        LIMIT ".($take)." OFFSET {$skip}")->execute()->fetchAllAssoc();
        
        return $products;
    }
}
