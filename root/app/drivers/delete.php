<?php

if ($_POST) {

    include_once "app/config/database.php";
    include_once "app/objects/driver.php";

    $database = new Database();
    $db = $database->getConnection();

    $driver = new Driver($db);

    $driver->id = $_POST["object_id"];

    if ($driver->delete()) {

        echo "Товар был удалён.";
    }

    else {
        echo "Невозможно удалить товар.";
    }
}
