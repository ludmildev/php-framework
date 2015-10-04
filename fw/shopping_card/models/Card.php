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
        
        if ($productId != 0)
        {
            $products[] = \FW\Common::normalize($productId, 'int');

            $session->cart = $products;

            $session->saveSession();
        }
    }
    
    public static function remove($productId = 0)
    {
        $session = \FW\App::getInstance()->getSession();
        
        $products = $session->cart;
        
        foreach($products as $key => $product) {
            if ($product == $productId) {
                unset($products[$key]);
                break;
            }
        }
        
        $session->cart = $products;
        
        $session->saveSession();
    }
}
