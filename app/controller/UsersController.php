<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("forms/UsersForm.php");


class UsersController {
    public static function index() {
        SessionsController::authorizeAdmin();

        echo ViewHelper::render("view/user-list.php", [
            "users" => UserDB::getAll()
        ]);
    }

    public static function register() {
        $form = new RegisterForm("register_form");

        if ($form->validate()) {
            $params = $form->getValue();
            $params['role_id'] = 3;
            $params['user_active'] = 1;
            $params['user_activation_token'] = 0;
            $params['user_activation_token_created_at'] = date("Y-m-d H:i:s");
            $params['user_created_at'] = date("Y-m-d H:i:s");

            UserDB::insert($params);
            ViewHelper::redirect(BASE_URL);
        }else {
            echo ViewHelper::render("view/user-register.php", [
                "form" => $form
            ]);
        }
    }

}
