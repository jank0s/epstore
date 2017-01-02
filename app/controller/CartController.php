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
       try{
            $vars = ["cart" => Cart::getAll(),
                "total" => Cart::total()];     
            echo ViewHelper::render("view/show-cart.php", $vars);

       } catch (Exception $ex) {
            echo("ni možno prikazati vozička" . $ex->getMessage());
       }
   }
   
    public static function remove(){
        SessionsController::authorizeCustomer();
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            try{
                Cart::remove($id);
            } catch (Exception $ex) {
                echo("napaka pri odstranjevanju izdelka" . $ex->getMessage());
            }
        }
        ViewHelper::redirect(BASE_URL . "cart");
   }
   
    public static function updateCart() {
        SessionsController::authorizeCustomer();
        $id = (isset($_POST["id"])) ? intval($_POST["id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;
        if(filter_var($id, FILTER_VALIDATE_INT) == false||filter_var($quantity, FILTER_VALIDATE_INT) == false) {
            $_SESSION['alerts'][0] = ["type" => "warning", "value" => "Količina ni celo število!"];
            ViewHelper::redirect(BASE_URL . "cart");
        }
        
        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "cart");
    }
   
    public static function addToCart() {
        SessionsController::authorizeCustomer();
        $id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            Cart::add($id);
            $_SESSION['alerts'][0] = ["type" => "success", "value" => "Izdelek dodan v košarico!"];
            ViewHelper::redirect(BASE_URL . "products");
            
        } else {
            $_SESSION['alerts'][0] = ["type" => "warning", "value" => "Dodajanje v košarico ni uspelo!"];
            ViewHelper::redirect(BASE_URL . "products");
        }
    }
    
    public static function review(){
        SessionsController::authorizeCustomer();
        try{
            $vars = ["cart" => Cart::getAll(),
                "user" => UserDB::get(["user_id" => $_SESSION['user']['user_id']]),
                "total" => Cart::total()];     
            echo ViewHelper::render("view/review.php", $vars);

       } catch (Exception $ex) {
            echo("ni možno prikazati vozička" . $ex->getMessage());
       }
    }
}
