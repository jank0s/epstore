<?php

require_once 'model/AbstractDB.php';

class ProductDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Product(product_name, product_description, product_price) VALUE (:product_name, :product_description, :product_price)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Product SET"
                . " product_name = :product_name, product_description = :product_description ,"
                . " product_price = :product_price"
                . " WHERE product_id = :product_id ", $params);
    }
    
    public static function setActive($id) {
        return parent::modify("UPDATE Product SET product_valid = 1 WHERE product_id = :id", ["id" => $id]);
    }
    
    public static function setInactive($id) {
        return parent::modify("UPDATE Product SET product_valid = 0 WHERE product_id = :id", ["id" => $id]);
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
    
 public static function getAllDashboard() {
        return parent::query("SELECT product_id, product_name, product_description, product_price, product_rating, product_valid"
                        . " FROM Product"
                        . " ORDER BY product_id ASC");
    }
    
    public static function getAll() {
        return parent::query("SELECT product_id, product_name, product_description, product_price, product_rating, product_valid"
                        . " FROM Product"
                        . " WHERE product_valid = 1"
                        . " ORDER BY product_id ASC");
    }
    
}
