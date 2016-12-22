<?php

require_once 'model/AbstractDB.php';

class RoleDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("", $params);
    }

    public static function update(array $params) {
        return parent::modify("", $params);
    }

    public static function delete(array $id) {
        return parent::modify("", $id);
    }

    public static function get(array $id) {
        $products = parent::query("", $id);
        
        if (count($products) == 1) {
            return $products[0];
        } else {
            throw new InvalidArgumentException("No such product");
        }
    }

    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM Role"
                        . " ORDER BY role_id ASC");
    }

    public static function dict() {
        $result = array();
        foreach (self::getAll() as $row) {
            $result[$row['role_name']] = $row['role_name'];
        }
        return $result;
    }

}
