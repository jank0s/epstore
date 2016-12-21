<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/SessionsForm.php");


class SessionsController {

    public static function index() {
        $form = new LoginForm("login_form");

        $x509email = self::getX509email();
        if($x509email != null){
            $form->email->setValue($x509email);
            $form->email->setAttribute('disabled');
        }

        echo ViewHelper::render("view/login.php", [
            "form" => $form
        ]);
    }

    public static function create(){
        $form = new LoginForm("login_form");

        $x509email = self::getX509email();
        if($x509email != null){
            $form->email->setValue($x509email);
        }
        if ($form->validate()) {
            $login_values = $form->getValue();
            $user = UserDB::getUserByEmail($login_values);
            if (isset($user) &&
                ( $x509email != null && $user['email'] == $x509email || $user['role_id'] == 3 ) &&
                $user['user_active'] == 1 &&
                password_verify($login_values['password'], $user['password_digest'])){

                $_SESSION['user']['user_id'] = $user['user_id'];
                $_SESSION['user']['role_id'] = $user['role_id'];
                $_SESSION['user']['name'] = $user['name'];
                $_SESSION['user']['surname'] = $user['surname'];
                $_SESSION['user']['email'] = $user['email'];

                echo ViewHelper::redirect(BASE_URL);
            }else{
                $form->email->setError('Prijava ni uspela!');
                if($x509email != null){
                    $form->email->setAttribute('disabled');
                }
                echo ViewHelper::render("view/login.php", [
                    "form" => $form
                ]);
            }
        } else {
            if($x509email != null){
                $form->email->setAttribute('disabled');
            }
            echo ViewHelper::render("view/login.php", [
                "form" => $form
            ]);
        }
    }

    public static function destroy() {
        session_destroy();
        #if(isset($_SESSION["user"])){
        #    unset($_SESSION["user"]);
        #}
        echo ViewHelper::redirect(BASE_URL);
        #session_destroy();
        #$url = "http://" . $_SERVER["HTTP_HOST"];
        #header("Location: " . $url);
    }

    public static function getX509email(){
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
        if ($client_cert != null) {
            $cert_data = openssl_x509_parse($client_cert);
            $email = (is_array($cert_data['subject']['emailAddress']) ?
                $cert_data['subject']['﻿emailAddress'][0] : $cert_data['subject']['emailAddress']);
            return $email;
        }else{
            return null;
        }
    }

    public static function loggedIn(){
        return isset($_SESSION['user']);
    }

    public static function customerAuthorized(){
        return  isset($_SESSION['user']) &&
                $_SESSION['user']['role_id'] == 3;
    }

    public static function authorizeCustomer(){
        if(!self::customerAuthorized()){
            ViewHelper::redirect(BASE_URL);
        }
    }

    public static function merchantAuthorized(){
        $x509email = self::getX509email();
        return  $x509email != null &&
                isset($_SESSION['user']) &&
                $_SESSION['user']['email'] == $x509email &&
                $_SESSION['user']['role_id'] == 2;
    }

    public static function authorizeMerchant(){
        if(!self::merchantAuthorized()){
            ViewHelper::redirect(BASE_URL);
        }
    }

    public static function adminAuthorized(){
        $x509email = self::getX509email();
        return  $x509email != null &&
        isset($_SESSION['user']) &&
        $_SESSION['user']['email'] == $x509email &&
        $_SESSION['user']['role_id'] == 1;
    }

    public static function authorizeAdmin(){
        if(!self::adminAuthorized()){
            ViewHelper::redirect(BASE_URL);
        }
    }

}
