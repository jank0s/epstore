<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");
require_once("forms/SearchForm.php");
require_once("forms/RateProductForm.php");
require_once("model/RatingDB.php");
require_once("forms/ImageForm.php");
require_once("model/ImageDB.php");

class ProductsController {

    public static function index() {
        
        $form = new SearchForm("search-form", $method='get');
        
        $products = ProductDB::getAll();
        
        if($form->validate()){
            $query = $form->getValue();
            $products = ProductDB::getBooleanSearchResult(["query" => $query['poizvedba']]);
            if(empty($products)){
                $products = ProductDB::getSearchResult(["query" => $query['poizvedba']]);
            }
            
            if(sizeof($products) > 0){
                echo ViewHelper::render("view/product-list.php", [
                        "form" => $form,
                    "products" => $products]);
            } else {
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Ni izdelka, ki bi ustrezal iskalnemu nizu."];
                echo ViewHelper::render("view/product-list.php", [
                        "form" => $form,
                    "products" => $products]);
            }
        } else {
            echo ViewHelper::render("view/product-list.php", [
                        "form" => $form,
                    "products" => $products]);
        }
    }
    
    public static function product_details($id) {
        $products = ProductDB::get(["product_id" => $id]);
        $form = new RateProductForm("rate-form", $method="post");
        $images = ImageDB::get(array('product_id' => $id));
        if($form->validate()){
            SessionsController::authorizeCustomer();
            $data = $form->getValue();
            $data["product_id"] = $id;
            $data["user_id"] = $_SESSION["user"]["user_id"]; 
            if (!RatingDB::get($data)){
                try{ 
                    RatingDB::insert($data);
                } catch (Exception $ex) {
                    echo ("napaka pri vnosu!". $ex->getMessage());
                }
                try{ 
                   RatingDB::update(["product_id" => $data["product_id"], "product_id2" => $data["product_id"]]);
                } catch (Exception $ex) {
                    echo ("napaka pri vnosu!". $ex->getMessage());
                } 
                
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Uspešno ste ocenili izdelek."];
                $products = ProductDB::get(["product_id" => $id]);
                echo ViewHelper::render("view/product-details.php",
                ["product" => $products, "form" => $form, "images" => $images]);
            } else {
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Ta izdelek ste že ocenili!"];
                echo ViewHelper::render("view/product-details.php",
                ["product" => $products, "form" => $form, "images" => $images]);
            }
        } else {
            echo ViewHelper::render("view/product-details.php",
                ["product" => $products, "form" => $form, "images" => $images]);
        }
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
                $id = ProductDB::insert($params);
                $product_name = $params["product_name"];
                UsersController::addLog($_SESSION['user']['user_id'], "added new product: $product_name [ID $id]");
                $_SESSION['alerts'][0] = ["type" => "success", "value" => "Uspešno dodan izdelek $params[product_name]!"];
                ViewHelper::redirect(BASE_URL . "products/dashboard");
            } catch (PDOException $e) {
                $_SESSION['alerts'][0] = ["type" => "danger", "value" => "Dodajanje izdelka ni blo uspešno!"];
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
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            try{
                ProductDB::setInactive($id);
                $product_name = ProductDB::get(["product_id" => $id])['product_name'];
                
                UsersController::addLog($_SESSION['user']['user_id'], "deactivated product:  $product_name [ID $id]");
                
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Izdelek $id uspešno deaktiviran."];
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
        $id = htmlspecialchars($id);
        $id = trim($id);
        if ($id !== null) {
            try{
                ProductDB::setActive($id);
                $product_name = ProductDB::get(["product_id" => $id])['product_name'];
                
                UsersController::addLog($_SESSION['user']['user_id'], "activated product:  $product_name [ID $id]");
                $_SESSION['alerts'][0] = ["type" => "info", "value" => "Izdelek $id uspešno aktiviran."];
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
                $product_name = $params["product_name"];
                UsersController::addLog($_SESSION['user']['user_id'], "edited product:  $product_name [ID $id]");
                $_SESSION['alerts'][0] = ["type" => "success", "value" => "Izdelek $id uspešno posodobljen."];
                ViewHelper::redirect(BASE_URL . "products/dashboard");
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
     public static function addImage($product_id) {
        SessionsController::authorizeMerchant();
        $images = ImageDB::get(array('product_id' => $product_id));
        $form = new ImageForm("image-form");
        if ($form->validate()) {
            $params = $form->getValue();
            $params['product_id'] = $product_id;
            try {
                $target_dir = "./static/images/";
                $temp = explode(".", $params['image_path']['name']);
                
                $target_file = round(microtime(true)) . "." . end($temp);            
                $params['image_name'] = $target_file;  
                move_uploaded_file($params["image_path"]["tmp_name"],
                        $target_dir . $target_file);
                ImageDB::insert($params);
                $product_name = ProductDB::get(["product_id" => $product_id])['product_name'];
                UsersController::addLog($_SESSION['user']['user_id'],
                        "added image $target_file for product: $product_name [ID $product_id]");
                $_SESSION['alerts'][0] = ["type" => "success", "value" => "Slika uspešno dodana."];
                ViewHelper::redirect(BASE_URL . "products/dashboard");
            } catch (PDOException $e) {
                    echo('Napaka'. $e->getMessage());
            }
        }else{
            echo ViewHelper::render("view/image-add.php", [
                "form" => $form,
                "images" => $images

            ]);
        }
    }
    
    public static function imageForm($product_id) {
        SessionsController::authorizeMerchant();

        $images = ImageDB::get(array('product_id' => $product_id));
        $form = new ImageForm("image-form");
        echo ViewHelper::render("view/image-add.php", [
                "form" => $form,
                "images" => $images
            ]);
    }
    
    public static function deleteImage(){
        SessionsController::authorizeMerchant();
        $id = isset($_POST["image_id"]) ? intval($_POST["image_id"]) : null;
        $id = htmlspecialchars($id);
        $id = trim($id);
        try{
            ImageDB::delete(["image_id" => $id]);
             $_SESSION['alerts'][0] = ["type" => "info", "value" => "Slika je bila izbrisana."];
            ViewHelper::redirect(BASE_URL . "products/dashboard");
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
    }
    
    public static function search($query){
        try{
            $form = new SearchForm("form-search");
            if($form->validate()){
                $query = $form->getValue();
                $products = ProductDB::getBooleanSearchResult(["query" => $query]);
                if(empty($products)){
                    $products = ProductDB::getSearchResult(["query" => $query]);
                }
                echo ViewHelper::render("view/product-list.php", [
                    "products" => $products
                ]);
            }
        } catch (Exception $e) {
            $_SESSION['alerts'][0] = ["type" => "info", "value" => "Ni izdelkov, ki bi ustrezali iskalnemu nizu."];
            ViewHelper::redirect(BASE_URL . "products");
        }
    }
}
