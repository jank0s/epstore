<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("forms/UsersForm.php");
require_once("lib/sendgrid-php/sendgrid-php.php");


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
            $params['user_active'] = 0;
            $params['user_activation_token'] = strtr(base64_encode(openssl_random_pseudo_bytes(48)), array('+'=>'-', '/'=>'_'));
            $params['user_activation_token_created_at'] = date("Y-m-d H:i:s");
            $params['user_created_at'] = date("Y-m-d H:i:s");

            try {
                $user_id = UserDB::insert($params);
                self::sendActivationEMail($user_id, $params['user_activation_token'], $params['email']);
                echo ViewHelper::render("view/user-register-success.php");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $form->email->setError('Email že obstaja!');
                    echo ViewHelper::render("view/user-register.php", [
                        "form" => $form
                    ]);
                } else {
                    echo('Napaka');
                }
            }
        }else {
            echo ViewHelper::render("view/user-register.php", [
                "form" => $form
            ]);
        }
    }

    public static function activate($user_id, $token) {
        $user = UserDB::get(["user_id" => $user_id]);
        if($user['user_activation_token'] == $token){
            UserDB::setActive($user_id);
            ViewHelper::redirect(BASE_URL . "login");
        }

    }

    public static function sendActivationEMail($user_id, $token, $email){
        $from = new SendGrid\Email(null, "no-reply@epstore.tk");
        $to = new SendGrid\Email(null, $email);
        $subject = "EPStore - Aktivacija računa";

        $activation_url = "https://" . $_SERVER["HTTP_HOST"] . BASE_URL . 'users/' . $user_id . '/activate/' . $token;

        $content = new SendGrid\Content("text/html", "<p>Račun lahko aktivirate na naslovu: <a href='" . $activation_url . "'></a>" . $activation_url ."</p>");
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = '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';
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
    }

}
