<?php

require_once 'model/AbstractDB.php';

class RatingDB extends AbstractDB {

   
    public static function get(array $params) {
        return parent::query("SELECT * FROM Rating WHERE product_id = :product_id"
                . " AND user_id = :user_id", $params);     
    }

    public static function delete(array $id) {
        
    }

    public static function getAll() {
        
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Rating(product_id, user_id, rating_value)"
                . " VALUE (:product_id, :user_id, :rating_value)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Product SET product_rating = (SELECT AVG(rating_value) from Rating WHERE product_id = :product_id) WHERE product_id = :product_id2", $params);
    }
    

}
