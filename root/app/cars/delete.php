<?php

if ($_POST) {

    include_once "app/config/database.php";
    include_once "app/objects/car.php";

    $database = new Database();
    $db = $database->getConnection();

    $car = new Car($db);

    $car->id = $_POST["object_id"];

    if ($car->delete()) {

        echo "Товар был удалён.";
    }

    else {
        echo "Невозможно удалить товар.";
    }
}
