<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
// enables sessions for the entire app
session_start();

require_once("controller/ProductsController.php");
require_once("controller/SessionsController.php");

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