<?php

require_once("ViewHelper.php");
require_once("forms/SessionsForm.php");


class SessionsController {

    public static function index() {
        $form = new LoginForm("login_form");

        if ($form->validate()) {
            #auth

            #ViewHelper::redirect(BASE_URL);
        } else {
            echo ViewHelper::render("view/login.php", [
                "form" => $form
            ]);
        }
    }

    public static function add() {

    }

    public static function edit() {

    }

    public static function delete() {

    }


    public static function create() {

    }

    public static function destroy() {

    }

}
