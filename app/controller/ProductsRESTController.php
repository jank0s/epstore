<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");
require_once("controller/SessionsController.php");
require_once("controller/UsersController.php");
require_once("lib/sendgrid-php/sendgrid-php.php");
require_once("forms/ProductsForm.php");


class ProductsRESTController {

    public static function index() {
        echo ViewHelper::renderJSON(ProductDB::getAll());
    }


}
