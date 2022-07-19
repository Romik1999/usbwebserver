<?php

$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

include_once "app/config/database.php";
include_once "app/objects/driver.php";
include_once "app/objects/car.php";
include_once "app/objects/category.php";

$database = new Database();
$db = $database->getConnection();

$driver = new Driver($db);
$car = new Car($db);
$category = new Category($db);

$driver->id = $id;

$driver->readOne();

$page_title = "Страница водителя";

require "app/layout_header.php";
?>

    <div class="right-button-margin">
        <a href="/drivers" class="btn btn-primary pull-right">
            Смотреть всех водителей
        </a>
    </div>

    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>ФИО</td>
            <td>
                <?= $driver->surname ?>
                <?= $driver->name ?>
                <?= $driver->patronymic ?>
            </td>
        </tr>
        <tr>
            <td>Дата рождения</td>
            <td><?= DateTime::createFromFormat('Y-m-d', $driver->birthday)->format('d-m-Y') ?></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><?= $driver->phone ?></td>
        </tr>


        <tr>
            <td colspan="2" style="text-align: center">Водительское удостоверение</td>
        </tr>
        <tr>
            <td>Серия и номер</td>
            <td><?= $driver->driving_license ?></td>
        </tr>
        <tr>
            <td>Дата выдачи</td>
            <td><?= DateTime::createFromFormat('Y-m-d', $driver->data_driving_license)->format('d-m-Y') ?></td>
        </tr>
        <tr>
            <td>Категории ТС</td>
            <td><?= implode(", ", json_decode($driver->allowed_category)) ?></td>
        </tr>
        <tr>
            <td>Доступные автомобили</td>
            <td><?= $driver->cars ?></td>
        </tr>
    </table>

<?php require "app/layout_footer.php"; ?>