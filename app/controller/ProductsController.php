<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");


class ProductsController {

    public static function index() {
        echo ViewHelper::render("view/product-list.php", [
            "products" => ProductDB::getAll()
        ]);
    }
    
    public static function product_details($id) {
        $products = ProductDB::get(["product_id" => $id]);
        echo ViewHelper::render("view/product-details.php",
                ["product" => $products]);
        
    }
    
    public static function product_dashboard(){
        SessionsController::authorizeMerchant();
        echo ViewHelper::render("view/product-dashboard.php", [
            "products" => ProductDB::getAllDashboard()
        ]);
    }
    
    public static function add() {
        SessionsController::authorizeMerchant();
        $form = new AddProductForm("add_product_form");

        if ($form->validate()) {
            $params = $form->getValue();
            if($_SESSION['user']['role_id']!=2){
                ViewHelper::redirect(BASE_URL);
            }
            try {
                ProductDB::insert($params);
            $_SESSION['alerts'][0] = ["type" => "success", "value" => "Uspešno dodan izdelek!"];
                ViewHelper::redirect(BASE_URL . "products/dashboard");
            } catch (PDOException $e) {
                $_SESSION['alerts'][0] = ["type" => "danger", "value" => "Izdelek ni bil uspešno dodan!"];
                echo ViewHelper::render("view/product-add.php", [
                    "form" => $form 
            ]);            
            }
        } else {
            echo ViewHelper::render("view/product-add.php", [
               "form" => $form 
            ]);
        }
    }
    
    public static function deactivate(){
        SessionsController::authorizeMerchant();
        $id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;    
        if ($id !== null) {
            try{
                ProductDB::setInactive($id);
                ViewHelper::redirect(BASE_URL . "products/dashboard");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju izdelka" . $ex->getMessage());
            }
        } else {
            echo("ID ni pravilen");
        }        
    }
       
    public static function activate($id){
        SessionsController::authorizeMerchant();
        $id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;    
        if ($id !== null) {
            try{
                ProductDB::setActive($id);
                ViewHelper::redirect(BASE_URL . "products/dashboard");
            } catch (Exception $ex) {
                echo("napaka pri potrjevanju izdelka" . $ex->getMessage());
            }
        } else {
            echo("ID ni pravilen");
        }
    }
    
    public static function edit($id) {
        SessionsController::authorizeMerchant();

        $form = new EditProductForm("form-edit");
        if ($form->validate()) {
            $params = $form->getValue();
            $params['product_id'] = $id;

            if($_SESSION['user']['role_id']!=2){
                ViewHelper::redirect(BASE_URL);
                echo("ni pravi user");
            }
            try {
                ProductDB::update($params);
                echo ViewHelper::render("view/product-add-success.php");
            } catch (PDOException $e) {
                var_dump($e);
                echo('Napaka');
            }
        }else{
            echo ViewHelper::render("view/product-edit.php", [
                "form" => $form
            ]);
        }
    }
    
    public static function editForm($product_id) {
        SessionsController::authorizeMerchant();

        $product = ProductDB::get(array('product_id' => $product_id));
        $form = null;
        if(SessionsController::merchantAuthorized()){
            $form = new EditProductForm("form-edit");
            $dataSource = new HTML_QuickForm2_DataSource_Array($product);
            $form->addDataSource($dataSource);
            echo ViewHelper::render("view/product-edit.php", [
                "form" => $form
            ]);
        }
    }
}
