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

    }

    public static function edit() {

    }
    
    //vrne error- class EditProductForm not found line 37
    public static function editForm($product_id) {
        $product = ProductDB::get(['product_id' => $product_id]);
        $form = null;
        if(SessionsController::merchantAuthorized()){
            $form = new EditProductForm("edit_product_form");
        }
        
        $dataSource = new HTML_QuickForm2_DataSource_Array($product);
        $form->addDataSource($dataSource);
        echo ViewHelper::render("view/product-edit.php", [
            "form" => $form
        ]);
    }

    public static function delete() {

    }

}
