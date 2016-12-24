<?php

require_once 'model/AbstractDB.php';

class ProductDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("", $params);
    }

    public static function update(array $params) {
        return parent::modify("", $params);
    }

    public static function delete(array $id) {
        return parent::modify("", $id);
    }

    public static function get(array $product_id) {
        $products = parent::query("SELECT * FROM Product WHERE product_id = :product_id", $product_id);    
        
        if (count($products) == 1) {
            return $products[0];
        } else {
            throw new InvalidArgumentException("No such product");
        }
    }

    public static function getAll() {
        return parent::query("SELECT product_id, product_name, product_description, product_price, product_rating"
                        . " FROM Product"
                        . " WHERE product_valid = 1"
                        . " ORDER BY product_id ASC");
    }

}
