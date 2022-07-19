<?php

$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

include_once "app/config/database.php";
include_once "app/objects/car.php";
include_once "app/objects/category.php";

$database = new Database();
$db = $database->getConnection();

$car = new Car($db);
$category = new Category($db);
$car->id = $id;

$car->readOne();

$page_title = "Страница автомобиля";

require "app/layout_header.php";
?>

    <div class="right-button-margin">
        <a href="/cars" class="btn btn-primary pull-right">
            Смотреть все автомобили
        </a>
    </div>

    <table class="table table-hover table-responsive table-bordered">

        <tr>
            <td>Марка</td>
            <td><?= $car->mark ?></td>
        </tr>

        <tr>
            <td>Гос. номер</td>
            <td><?= $car->state_number ?></td>
        </tr>

        <tr>
            <td>Год выпуска</td>
            <td><?= $car->year_issue ?></td>
        </tr>

        <tr>
            <td>Номер шасси</td>
            <td><?= $car->chassis_number ?></td>
        </tr>

        <tr>
            <td>Номер кузова</td>
            <td><?= $car->body_number ?></td>
        </tr>
        <tr>
            <td>Категория ТС</td>
            <td><?= $car->vehicle_category ?></td>
        </tr>

    </table>

<?php require_once "app/layout_footer.php"; ?>