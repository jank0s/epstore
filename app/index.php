<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
// enables sessions for the entire app
if(isset($_SERVER["HTTPS"])){
    session_start();
}

require_once("controller/ProductsController.php");
require_once("controller/ProductsRESTController.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("controller/CartController.php");
require_once("controller/OrderController.php");

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
        } else {
            ProductsController::product_details($id);
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
    "/^products\/deactivate$/" => function ($method) {
        ProductsController::deactivate();
    },
    "/^products\/activate$/" => function ($method) {
        ProductsController::activate();
    },
    "/^products\/add-to-cart$/" => function ($method) {
        if($method == 'POST'){
            CartController::addToCart();
        } else {
            ViewHelper::redirect(BASE_URL . "products");
        }
    },      
    "/^cart$/" => function ($method) {
        CartController::showCart();
    },
    "/^cart\/update$/" => function ($method) {
        CartController::updateCart();
    },
    "/^cart\/remove$/" => function ($method) {
        if($method == 'POST'){
            CartController::remove();
        }
    },
    "/^cart\/review$/" => function ($method) {
        CartController::review();
    },
    "/^cart\/create-invoice$/" => function ($method) {
        OrderController::createInvoice();
    },
    "/^login$/" => function ($method) {
        if($method == 'POST'){
            SessionsController::create();
        }else{
            SessionsController::index();
        }
    },
    "/^history$/" => function ($method) {
        OrderController::historyForUser();
    },
    "/^history\/(\d+)$/" => function ($method, $id) {
        OrderController::orderDetailUser($id);
    },
    "/^orders\/(\d+)$/" => function ($method, $id) {
        OrderController::orderDetailMerchant($id);
    },
            
    "/^orders$/" => function ($method) {
        OrderController::submittedOrders();
    },
    "/^orders\/activate$/" => function ($method) {
        if($method == 'POST'){
            OrderController::activate();
        }
    },
    "/^orders\/deactivate$/" => function ($method) {
        if($method == 'POST'){
            OrderController::deactivate();
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
    "/^users\/deactivate$/" => function ($method) {
        UsersController::deactivate();
        
    },
    "/^users\/activate$/" => function ($method) {
        UsersController::reactivate();
        
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
    # REST API
    "/^api\/products\/(\d+)$/" => function ($method, $id = null) {
        // TODO: izbris knjige z uporabo HTTP metode DELETE
        switch ($method) {
            case "PUT":
                break;
            case "DELETE":
                break;
            default: # GET
                break;
        }
    },
    "/^api\/products$/" => function ($method, $id = null) {
        switch ($method) {
            case "POST":
                break;
            default: # GET
                ProductsRESTController::index();
                break;
        }
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