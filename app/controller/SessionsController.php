<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/SessionsForm.php");


class SessionsController {

    public static function index() {
        $form = new LoginForm("login_form");

        echo ViewHelper::render("view/login.php", [
            "form" => $form
        ]);
    }

    public static function create(){
        $form = new LoginForm("login_form");

        if ($form->validate()) {
            $login_values = $form->getValue();
            $user = UserDB::getUserByEmail($login_values);
            if (isset($user) &&
                $user['user_active'] == 1 &&
                password_verify($login_values['password'], $user['password_digest'])){

                $_SESSION['user']['user_id'] = $user['user_id'];
                $_SESSION['user']['role_id'] = $user['role_id'];
                $_SESSION['user']['name'] = $user['name'];
                $_SESSION['user']['surname'] = $user['surname'];

                echo ViewHelper::redirect(BASE_URL);
            }else{
                $form->email->setError('Prijava ni uspela!');
                echo ViewHelper::render("view/login.php", [
                    "form" => $form
                ]);
            }
        } else {
            echo ViewHelper::render("view/login.php", [
                "form" => $form
            ]);
        }
    }

    public static function destroy() {
        if(isset($_SESSION["user"])){
            unset($_SESSION["user"]);
        }
        echo ViewHelper::redirect(BASE_URL);
    }

}
