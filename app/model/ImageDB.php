<?php

require_once 'model/AbstractDB.php';

class ImageDB extends AbstractDB {

   
    public static function get(array $product_id) {
               return parent::query("SELECT * FROM Image WHERE product_id = :product_id", $product_id);
  
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Image WHERE image_id = :image_id", $id);
    }

    public static function getAll() {
        
    }

    public static function getByImageID(array $image_id) {
        $image= parent::query("SELECT * FROM Image WHERE image_id = :image_id", $image_id);
        if (count($image) == 1) {
            return $image[0];
        } else {
            throw new InvalidArgumentException("No such product");
        }
    }
    
     public static function insert(array $params) {
        return parent::modify("INSERT INTO Image(product_id, image_name) VALUE (:product_id, :image_name)", ["product_id" => $params['product_id'] ,"image_name" => $params['image_name']]);
    }

    public static function update(array $params) {
        
    }

}
