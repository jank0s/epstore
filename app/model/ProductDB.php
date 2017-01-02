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
    
    public static function getSearchResult(array $query) {
        return parent::query("SELECT * FROM Product WHERE MATCH(product_name, product_description) AGAINST (:query IN BOOLEAN MODE) AND product_valid = 1", $query);
    }
    
    public static function getForIds(array $ids) {
        $db = self::getConnection();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));
      #  echo($id_placeholders);
        $statement = $db->prepare("SELECT *
            FROM Product 
            WHERE product_id IN (" . $id_placeholders . ")");
        $statement->execute($ids);
        
        return $statement->fetchAll();       
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
    
     public static function getRatingCount() {
        return parent::query("SELECT product_id, COUNT(*) AS rating_count FROM Rating GROUP BY product_id");
    }
    

    public static function getAllwithURI(array $prefix) {
        return parent::query("SELECT product_id as id, product_name as name, product_description as description, product_price as price, product_rating as rating, "
            . "          CONCAT(:prefix, product_id) as uri "
            . "FROM Product "
            . "ORDER BY product_id ASC", $prefix);
    }

    public static function getShort(array $product_id) {
        $products = parent::query("SELECT product_id as id, product_name as name, product_description as description, product_price as price, product_rating as rating FROM Product WHERE product_id = :product_id", $product_id);

        if (count($products) == 1) {
            return $products[0];
        } else {
            throw new InvalidArgumentException("No such product");
        }
    }
    
}
