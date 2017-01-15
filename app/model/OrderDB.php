<?php

require_once 'model/AbstractDB.php';

class OrderDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO `Order` (user_id, status_id,"
                . " order_created_at, order_updated_at, delivery_address, delivery_post,"
                . " delivery_city, delivery_country, payment_option_id) VALUE (:user_id, :status_id,"
                . " :order_created_at, :order_updated_at, :delivery_address, :delivery_post,"
                . " :delivery_city, :delivery_country, :payment_option_id)", $params);
    }
    
    public static function insertOrderProduct(array $params) {
        return parent::modify("INSERT INTO Order_item (order_id, product_id, item_price, item_quantity)"
                . " VALUES (:order_id, :product_id, :product_price, :quantity)", $params);
    }
    
    public static function getForUser($id) {
        return parent::query("SELECT *"
                        . " FROM `Order`"
                        . " WHERE user_id = :user_id", $id);
    }
    
    public static function getOrderDetails($id) {
        return parent::query("SELECT * FROM epstore.`Order`, Order_item,"
           . " Product, `User` WHERE `User`.user_id = `Order`.user_id AND"
           . " Product.product_id = Order_item.product_id AND"
           . " `Order`.order_id = Order_item.order_id"
           . " AND `Order`.order_id = :order_id", $id);
    }
    
    
    public static function update(array $params) {
        return parent::modify("UPDATE Product SET"
                . " product_name = :product_name, product_description = :product_description ,"
                . " product_price = :product_price"
                . " WHERE product_id = :product_id ", $params);
    }
    
    public static function activate(array $params) {
        return parent::modify("UPDATE `Order` SET status_id = 2, order_updated_at = :order_updated_at WHERE order_id = :order_id ", $params);
    }
    
    public static function deactivate(array $params) {
        return parent::modify("UPDATE `Order` SET status_id = 3, order_updated_at = :order_updated_at WHERE order_id = :order_id ", $params);
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
    
    public static function getForIds(array $ids) {
        $db = self::getConnection();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));
        $statement = $db->prepare("SELECT *
            FROM Product 
            WHERE product_id IN (" . $id_placeholders . ")");
        $statement->execute($ids);
        
        return $statement->fetchAll();       
    }
    
    public static function getAllUnconfirmed() {
        return parent::query("SELECT * FROM `Order`");
    }
    
    public static function getAll() {
        return parent::query("SELECT product_id, product_name, product_description, product_price, product_rating, product_valid"
                        . " FROM Product"
                        . " WHERE product_valid = 1"
                        . " ORDER BY product_id ASC");
    }
    
}
