<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB {

    public static function insert(array $params) {
        $params['password_digest'] = password_hash($params['password'], PASSWORD_DEFAULT);
        #var_dump($params);
        return parent::modify("INSERT INTO User (email, name, surname, password_digest, phone, role_id, user_active, user_activation_token, user_activation_token_created_at, user_created_at, user_address, user_post, user_city, user_country) "
                ."VALUE (:email, :name, :surname, :password_digest, :phone, :role_id, :user_active, :user_activation_token, :user_activation_token_created_at, :user_created_at, :user_address, :user_post, :user_city, :user_country)", $params);
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

    public static function getUserByEmail(array $email) {
        $users = parent::query("SELECT * FROM User WHERE email = :email", $email);
        if (count($users) == 1) {
            return $users[0];
        } else {
            return null;
        }
    }

    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM User NATURAL JOIN Role"
                        . " ORDER BY user_id ASC");
    }

}
