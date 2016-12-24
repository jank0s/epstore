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
    
    public static function product_dashboard(){
        echo ViewHelper::render("view/product-dashboard.php", [
            "products" => ProductDB::getAll()
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
                echo ViewHelper::render("view/product-add-success.php");
            } catch (PDOException $e) {
                var_dump($e);
                echo('Napaka');
            }
        } else {
            echo ViewHelper::render("view/product-add.php", [
               "form" => $form 
            ]);
        }
    }
    
    //TODO: if empty, require params
    public static function edit($id) {
        $form = null;  
        if(SessionsController::merchantAuthorized()){
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
            } 
        }
    }
    
    public static function editForm($product_id) {
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

    public static function delete() {

    }

}
