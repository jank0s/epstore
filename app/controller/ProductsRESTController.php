<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");


class ProductsRESTController {

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
            . $_SERVER["REQUEST_URI"] . "/";
        echo ViewHelper::renderJSON(ProductDB::getAllwithURI(["prefix" => $prefix]));
    }

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(ProductDB::getShort(["product_id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

}
