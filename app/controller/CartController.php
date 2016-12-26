<?php

require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");
require_once("model/Cart.php");

#TODO:add filter_sanitize
class CartController {
   
    public static function showCart(){
       SessionsController::authorizeCustomer();
       $vars = ["cart" => Cart::getAll(),
           "total" => Cart::total()];
            
       echo ViewHelper::render("view/show-cart.php", $vars);
   }
   
    public static function remove(){
       SessionsController::authorizeCustomer();
       $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;    
       $id = htmlspecialchars($id);
       if ($id !== null) {
            Cart::remove($id);
            
       }
      ViewHelper::redirect(BASE_URL . "cart");

   }
   
    public static function updateCart() {
        SessionsController::authorizeCustomer();
        $id = (isset($_POST["id"])) ? intval($_POST["id"]) : null;
        $id = htmlspecialchars($id);
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "cart");
    }
   
    public static function addToCart() {
        SessionsController::authorizeCustomer();
        $id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;
        $id = htmlspecialchars($id);
        if ($id !== null) {
            Cart::add($id);
            echo ViewHelper::render("view/cart-add-success.php");
        } else {
            echo("ni dodan v košarico!");
            var_dump($_SESSION['cart']);
        }
    }
}
