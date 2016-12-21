<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");


class UsersController {
    public static function index() {
        SessionsController::authorizeAdmin();

        echo ViewHelper::render("view/user-list.php", [
            "users" => UserDB::getAll()
        ]);
    }

    public static function register() {
        $form = null;

        echo ViewHelper::render("view/user-register.php", [
            "form" => $form
        ]);
    }

}
