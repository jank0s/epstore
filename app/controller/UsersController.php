<?php

require_once("model/UserDB.php");
require_once("model/RoleDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("forms/UsersForm.php");
require_once("lib/sendgrid-php/sendgrid-php.php");


class UsersController {
    public static function index() {
        SessionsController::authorizeAdminOrMerchant();

        echo ViewHelper::render("view/user-list.php", [
            "users" => (SessionsController::adminAuthorized()? UserDB::getAll() : UserDB::getAllCustomers())
        ]);
    }

    public static function register() {
        $form = new RegisterUserForm("register_form");

        if ($form->validate()) {
            $params = $form->getValue();
            $params['role_id'] = 3;
            $params['user_active'] = 0;
            $params['user_activation_token'] = strtr(base64_encode(openssl_random_pseudo_bytes(48)), array('+'=>'-', '/'=>'_'));
            $params['user_activation_token_created_at'] = date("Y-m-d H:i:s");
            $params['user_created_at'] = date("Y-m-d H:i:s");

            try {
                $params['user_id'] = UserDB::insert($params);
                self::sendActivationEMail($params);

                $_SESSION['alerts'][] = ["type" => "success", 'value' => "Registracija uspešna! V nekaj minutah boste prejeli elektronsko sporočilo z navodili za potrditev vašega računa."];
                echo ViewHelper::redirect(BASE_URL);
                #echo ViewHelper::render("view/user-register-success.php");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $form->email->setError('Email že obstaja!');
                    echo ViewHelper::render("view/user-register.php", [
                        "form" => $form
                    ]);
                } else {
                    var_dump($e);
                    echo('Napaka');
                }
            }
        }else {
            echo ViewHelper::render("view/user-register.php", [
                "form" => $form
            ]);
        }
    }

    public static function add(){
        SessionsController::authorizeAdminOrMerchant();

        $form = new AddUserForm("add_user_form");

        if ($form->validate()) {
            $params = $form->getValue();
            if($params['role_id']==1 && $_SESSION['user']['role_id']!=1){
                ViewHelper::redirect(BASE_URL);
            }

            $params['user_active'] = 1;
            $params['user_activation_token'] = 0;
            $params['user_activation_token_created_at'] = date("Y-m-d H:i:s");
            $params['user_created_at'] = date("Y-m-d H:i:s");

            if($params['role_id']!=3){
                $params['user_address'] = "";
                $params['user_post'] = 0;
                $params['user_city'] = "";
                $params['user_country'] = "";
            }

            try {
                $params['user_id'] = UserDB::insert($params);
                echo ViewHelper::render("view/user-register-success.php");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $form->email->setError('Email že obstaja!');
                    echo ViewHelper::render("view/user-add.php", [
                        "form" => $form
                    ]);
                } else {
                    var_dump($e);
                    echo('Napaka');
                }
            }
        }else {
            echo ViewHelper::render("view/user-add.php", [
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
    
    public static function reactivate($user_id) {
        SessionsController::authorizeAdminOrMerchant();
        $user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : null;    
        if ($user_id !== null) {
            try{
                UserDB::setActive($user_id);
                ViewHelper::redirect(BASE_URL . "users");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju" . $ex->getMessage());
            }
        } else {
            echo("ID ni pravilen");
        }  
    }
    public static function deactivate() {
        SessionsController::authorizeAdminOrMerchant();
        $user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : null;    
        if ($user_id !== null) {
            try{
                UserDB::setInactive($user_id);
                ViewHelper::redirect(BASE_URL . "users");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju" . $ex->getMessage());
            }
        } else {
            echo("ID ni pravilen");
        }
    }

    public static function edit($user_id){
        SessionsController::authorizeAllowEditUser($user_id);
        $form = null;

        if(SessionsController::adminAuthorized()){
            if($_SESSION['user']['user_id'] == $user_id){
                $form = new EditAdminUserForm("add_user_form", true);
            }else{
                $form = new EditAdminUserForm("add_user_form", false);
            }
        }else if(SessionsController::merchantAuthorized() && $_SESSION['user']['user_id'] == $user_id){
            $form = new EditMerchantUserForm("edit_user_form", true);
        }else{
            if($_SESSION['user']['user_id'] == $user_id){
                $form = new EditUserForm("edit_user_form", true);
            }else{
                $form = new EditUserForm("edit_user_form", false);
            }
        }

        if ($form->validate()) {
            $params = $form->getValue();
            $currentParams=UserDB::get(['user_id' => $user_id]);
            if(!isset($params['role_id'])){
                $params['role_id']=$currentParams['role_id'];
            }
            if($params['role_id']==1 && $_SESSION['user']['role_id']!=1){
                ViewHelper::redirect(BASE_URL);
            }


            if($params['role_id']!=3){
                $params['user_address'] = "";
                $params['user_post'] = 0;
                $params['user_city'] = "";
                $params['user_country'] = "";
                $params['phone'] = "";
            }

            $params['user_id'] = $user_id;
            try {
                $params['user_id'] = UserDB::update($params);
                self::updateCurrentUser($params['user_id']);
                ViewHelper::redirect(BASE_URL . "users/" . $user_id . "/edit");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $form->email->setError('Email že obstaja!');
                    echo ViewHelper::render("view/user-edit.php", [
                        "form" => $form
                    ]);
                } else {
                    var_dump($e);
                    echo('Napaka');
                }
            }
        }else {
            echo ViewHelper::render("view/user-edit.php", [
                "form" => $form
            ]);
        }
    }

    public static function editForm($user_id){
        SessionsController::authorizeAllowEditUser($user_id);
        $user = UserDB::get(['user_id' => $user_id]);
        $form = null;

        if(SessionsController::adminAuthorized()){
            if($_SESSION['user']['user_id'] == $user_id){
                $form = new EditAdminUserForm("add_user_form", true);
            }else{
                $form = new EditAdminUserForm("add_user_form", false);
            }
        }else if(SessionsController::merchantAuthorized() && $_SESSION['user']['user_id'] == $user_id){
            $form = new EditMerchantUserForm("edit_user_form", true);
        }else{
            if($_SESSION['user']['user_id'] == $user_id){
                $form = new EditUserForm("edit_user_form", true);
            }else{
                $form = new EditUserForm("edit_user_form", false);
            }
        }

        $dataSource = new HTML_QuickForm2_DataSource_Array($user);
        $form->addDataSource($dataSource);
        echo ViewHelper::render("view/user-edit.php", [
            "form" => $form
        ]);

    }


    public static function sendActivationEMail($params){
        $from = new SendGrid\Email("EPStore", "no-reply@epstore.tk");
        $to = new SendGrid\Email($params['name'] . " " . $params['surname'], $params['email']);
        $subject = "EPStore - Aktivacija računa";

        $activation_url = "https://" . $_SERVER["HTTP_HOST"] . BASE_URL . 'users/' . $params['user_id'] . '/activate/' . $params['user_activation_token'];

        $content = new SendGrid\Content("text/html", "<p>Račun lahko aktivirate na naslovu: <a href='" . $activation_url . "'></a>" . $activation_url ."</p>");
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = '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';
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
    }

    public static function updateCurrentUser(){
        $user = UserDB::get(['user_id' => $_SESSION['user']['user_id']]);
        $_SESSION['user']['user_id'] = $user['user_id'];
        $_SESSION['user']['role_id'] = $user['role_id'];
        $_SESSION['user']['name'] = $user['name'];
        $_SESSION['user']['surname'] = $user['surname'];
        $_SESSION['user']['email'] = $user['email'];
    }

}
