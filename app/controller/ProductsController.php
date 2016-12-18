<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");


class ProductsController {

    public static function index() {
        echo ViewHelper::render("view/product-list.php", [
            "products" => ProductDB::getAll()
        ]);
    }

    public static function add() {

    }

    public static function edit() {

    }

    public static function delete() {

    }

}
