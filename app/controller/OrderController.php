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
        if(isset($_SESSION['cart'])){
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
                    echo "napaka pri vstavljanju";
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
                $_SESSION['alerts'][0] = ["type" => "success", "value" => "Naročilo uspešno oddano v obdelavo!"];
                echo ViewHelper::redirect(BASE_URL . "products");             
            } catch(Exception $ex){
                $_SESSION['alerts'][0] = ["type" => "warning", "value" => "Naročilo ni bilo uspešno oddano!"];
                echo ViewHelper::redirect(BASE_URL . "products");            
            }
        } else {
            echo "ni možno oddati praznega naročila!";
        }
    }
    
    public static function historyForUser(){
        SessionsController::authorizeCustomer();
        $user = $_SESSION['user']['user_id'];
        $orders = OrderDB::getForUser(["user_id" => $user]);
        #var_dump($data);
        echo ViewHelper::render("view/order-history.php", ["orders" => $orders
                ]);
    }
    
    public static function orderDetailUser($id){
        SessionsController::authorizeCustomer();
        $order = OrderDB::getOrderDetails(["order_id" => $id]);
        $sum = 0;
        foreach ($order as $product){
            $sum += ($product['product_price'] * $product["item_quantity"]);
        }
        echo ViewHelper::render("view/order-detail.php", ["order" => $order, "sum" => $sum
                ]);
    }
    
    public static function submittedOrders(){
        SessionsController::authorizeMerchant();
        $orders = OrderDB::getAllUnconfirmed();
        
        echo ViewHelper::render("view/order-unconfirmed.php", ["orders" => $orders
                ]);
    }
    
    public static function orderDetailMerchant($id){
        SessionsController::authorizeMerchant();
        $order = OrderDB::getOrderDetails(["order_id" => $id]);
        $sum = 0;
        foreach ($order as $product){
            $sum += ($product['product_price'] * $product["item_quantity"]);
        }
        echo ViewHelper::render("view/order-detail.php", ["order" => $order, "sum" => $sum
                ]);
    }
    
    public static function activate(){
        SessionsController::authorizeMerchant();
        $id = isset($_POST["order_id"]) ? intval($_POST["order_id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            try{
            $order_updated_at = date("Y-m-d H:i:s");
                OrderDB::activate(["order_updated_at" => $order_updated_at, "order_id" =>$id]);
                UsersController::addLog($_SESSION['user']['user_id'], "confirmed order ID " . $id);
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Naročilo $id uspešno potrjeno."];
                ViewHelper::redirect(BASE_URL . "orders");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju izdelka" . $ex->getMessage());
            }
        } 
   }
   public static function deactivate(){
        SessionsController::authorizeMerchant();
        $id = isset($_POST["order_id"]) ? intval($_POST["order_id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            try{
            $order_updated_at = date("Y-m-d H:i:s");
                OrderDB::deactivate(["order_updated_at" => $order_updated_at, "order_id" =>$id]);
                UsersController::addLog($_SESSION['user']['user_id'], "canceled order ID " . $id);
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Naročilo $id uspešno stornirano."];
                ViewHelper::redirect(BASE_URL . "orders");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju izdelka" . $ex->getMessage());
            }
        } 
   }
}