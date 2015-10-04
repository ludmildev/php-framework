<?php
namespace Models;

class Card {
    
    public static function add($productId = 0)
    {
        $session = \FW\App::getInstance()->getSession();
        
        if (count($session->cart) == 0) {
            $session->cart = array();
        }
        $products = $session->cart;
        
        $products[] = $productId;
        
        $session->cart = $products;
        
        $session->saveSession();
    }
}
