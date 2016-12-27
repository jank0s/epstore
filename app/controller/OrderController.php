<?php

require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");
require_once("model/Cart.php");
require_once("model/OrderDB.php");

#TODO:add filter_sanitize
class OrderController {
    public static function createInvoice(){
        SessionsController::authorizeCustomer();
        try{
            $params = Cart::getAll();
            $user = UserDB::get(["user_id" => $_SESSION['user']['user_id']]);
            #insert order
            $order = array();
            $order['user_id'] = $user['user_id'];
            $order['status_id'] = intval(1);
            $order['order_created_at'] = date("Y-m-d H:i:s");
            $order['order_updated_at'] = date("Y-m-d H:i:s");
            $order['delivery_address'] = $user['user_address'];
            $order['delivery_post'] = intval($user['user_post']);
            $order['delivery_city'] = $user['user_city'];
            $order['delivery_country'] = $user['user_country'];
            #todo
            $order['payment_option_id'] = 1;
            try{
                $order_id =  OrderDB::insert($order);            
            } catch (Exception $ex) {

            }
            #podatki za order_product > order_id, product_id, item_price, item_quantity
            foreach ($params as $product){
                $product['order_id'] = $order_id;
                $product['product_id']; 
                $product['product_price']; 
                $product['quantity'];
                OrderDB::insertOrderProduct($product);
            } 
            #   ko se ustvari naročilo izprazni košarico 
            unset($_SESSION['cart']);
            echo ViewHelper::render("view/order-success.php");             
        } catch(Exception $ex){
                echo("neuspesno vnašanje naročila " . $ex->getMessage());
        }
    }
}