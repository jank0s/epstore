<?php

require_once("model/ProductDB.php");

class Cart {
    
    public static function getAll() {
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return [];
        }
        
        $ids = array_keys($_SESSION["cart"]);
        $cart = ProductDB::getForIds($ids);
        
        // Adds a quantity field to each book in the list
        foreach ($cart as &$product) {
            $product["quantity"] = $_SESSION["cart"][$product["product_id"]];
        }
        return $cart;
    }
    
    #dodajanje v cart
    public static function add($id) {
        $product = ProductDB::get(["product_id" => $id]);
        try{
            if ($product != null) {
                if (isset($_SESSION["cart"][$id])) {
                    $_SESSION["cart"][$id] += 1;
                } else {
                    $_SESSION["cart"][$id] = 1;
                }            
            }
        } catch (Exception $ex){
            die($ex->getMessage());
        }
    }

    public static function update($id, $quantity) {
       $product = ProductDB::get(["product_id" =>$id]);
       $quantity = intval($quantity);

        if ($product != null) {
            if ($quantity <= 0) {
                unset($_SESSION["cart"][$id]);
            } else {
                $_SESSION["cart"][$id] = $quantity;
            }
        }
    }
    public static function remove($id) {
       $product = ProductDB::get(["product_id" => $id]);
        if ($product != null) {
            unset($_SESSION["cart"][$id]);
        }
    }
    
    public static function total() {
        return array_reduce(self::getAll(), function ($total, $book) {
            return $total + $book["product_price"] * $book["quantity"];
        }, 0);
    }
}
