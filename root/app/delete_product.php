<?php

if ($_POST) {

    include_once "config/database.php";
    include_once "objects/product.php";

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $product->id = $_POST["object_id"];

    if ($product->delete()) {
        echo "Товар был удалён.";
    }

    else {
        echo "Невозможно удалить товар.";
    }
}
