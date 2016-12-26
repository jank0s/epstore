<?php
require_once("model/UserDB.php");
require_once("model/RoleDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("forms/UsersForm.php");

require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");
require_once("model/Cart.php");


class CartController {
    
    public static function home() {
/*
        $cart = Cart::getAll();
      var_dump($cart);

      $vars = [
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];
  */    
        ViewHelper::render("view/cart.php", [
                        "cart" => $cart
                    ]);
        
   }
   
   public static function showCart(){
       $cart = Cart::getAll();
       echo ViewHelper::render("view/show-cart.php", [
                        "cart" => $cart
                    ]);
        
   }
 

    public static function addToCart() {
        $id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;
        
        if ($id !== null) {
            Cart::add($id);
            echo ViewHelper::render("view/cart-add-success.php");
        } else {
            echo("ni dodan v košarico!");
            var_dump($_SESSION['cart']);
        }
    }

    public static function updateCart() {
        $id = (isset($_POST["id"])) ? intval($_POST["id"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function purgeCart() {
        Cart::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }
     

}
