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

        echo ViewHelper::render("view/user-register.php", [
            "form" => $form
        ]);
    }

}
