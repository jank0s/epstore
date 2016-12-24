<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
// enables sessions for the entire app
if(isset($_SERVER["HTTPS"])){
    session_start();
}

require_once("controller/ProductsController.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");
define("FONT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/fonts/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// ROUTER: defines mapping between URLS and controllers
$urls = [
    "/^products\/?(\d+)?$/"  => function ($method, $id = null) {
        if ($id == null) {
            ProductsController::index();
        }
    },
    "/^products\/dashboard$/" => function($method) {
        ProductsController::product_dashboard();
    },
    "/^products\/(\d+)\/edit$/" => function ($method, $id) {
        if ($method == 'POST'){
            ProductsController::edit($id);
        }else{
            ProductsController::editForm($id);
        }
    },
    "/^products\/add$/" => function ($method) {
        ProductsController::add();
    },
    "/^products\/(\d+)\/deactivate$/" => function ($method, $id) {
        ProductsController::deactivate($id);
        
    },
    "/^products\/(\d+)\/activate$/" => function ($method, $id) {
        ProductsController::activate($id);
        
    },
    "/^login$/" => function ($method) {
        if($method == 'POST'){
            SessionsController::create();
        }else{
            SessionsController::index();
        }
    },
    "/^logout$/" => function ($method) {
        SessionsController::destroy();
    },

    "/^users$/" => function ($method) {
        UsersController::index();
    },
    "/^users\/add$/" => function ($method) {
        UsersController::add();
    },
    "/^users\/(\d+)\/activate\/([a-zA-Z0-9-_]*)$/" => function ($method, $id, $token) {
        UsersController::activate($id, $token);
    },
    "/^users\/(\d+)\/deactivate$/" => function ($method, $id) {
        UsersController::deactivate($id);
        
    },
            
    "/^users\/(\d+)\/activate$/" => function ($method, $id) {
        UsersController::reactivate($id);
        
    },
 
    "/^users\/(\d+)$/" => function ($method, $id) {
        var_dump($id);
    },
    "/^users\/(\d+)\/edit$/" => function ($method, $id) {
        if ($method == 'POST'){
            UsersController::edit($id);
        }else{
            UsersController::editForm($id);
        }

    },
    "/^register$/" => function ($method) {
        UsersController::register();
    },            
    "/^$/" => function () {
        ViewHelper::redirect(BASE_URL . "products");
    },
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            ViewHelper::error404();
        } catch (Exception $e) {
            ViewHelper::displayError($e, true);
        }

        exit();
    }
}

ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);