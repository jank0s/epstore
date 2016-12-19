<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("", $params);
    }

    public static function update(array $params) {
        return parent::modify("", $params);
    }

    public static function delete(array $id) {
        return parent::modify("", $id);
    }

    public static function get(array $user_id) {
        $users = parent::query("", $user_id);
        
        if (count($users) == 1) {
            return $users[0];
        } else {
            throw new InvalidArgumentException("No such user");
        }
    }

    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM User"
                        . " ORDER BY user_id ASC");
    }

}