<?php
$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

include_once "app/config/core.php";
include_once "app/config/database.php";
include_once "app/objects/driver.php";
include_once "app/objects/category.php";
include_once "app/objects/car.php";

$database = new Database();
$db = $database->getConnection();

$driver = new Driver($db);
$category = new Category($db);
$car = new Car($db);

$driver->id = $id;

$driver->readOne();

$page_title = "Обновление водителя";

include "app/layout_header.php";
?>

<div class="right-button-margin">
    <a href="/drivers" class="btn btn-default pull-right">Просмотр всех водителей</a>
</div>

<?php

if ($_POST) {

    $driver->surname = $_POST["surname"];
    $driver->name = $_POST["name"];
    $driver->patronymic = $_POST["patronymic"];
    $driver->birthday = $_POST["birthday"];
    $driver->phone = $_POST["phone"];
    $driver->driving_license = $_POST["driving_license"];
    $driver->data_driving_license = $_POST["data_driving_license"];
    $driver->allowed_category = $_POST["allowed_category"];
    $driver->cars = $_POST["cars"];

    if ($driver->update()) {
        echo "<div class='alert alert-success alert-dismissable'>Товар был обновлён.</div>";
    } else {
        echo "<div class='alert alert - danger alert - dismissable'>Невозможно обновить товар.</div>";
    }
}
?>

<form action="/drivers/update?id=<?= $id ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">

        <tr>
            <td>Фамиилия</td>
            <td><input type="text" name="surname" value="<?= $driver->surname ?>" class="form-control"/></td>
        </tr>
        <tr>
            <td>Имя</td>
            <td><input type="text" name="name" value="<?= $driver->name ?>" class="form-control"/></td>
        </tr>
        <tr>
            <td>Отчество</td>
            <td><input type="text" name="patronymic" value="<?= $driver->patronymic ?>" class="form-control"/></td>
        </tr>
        <tr>
            <td>Дата рождения</td>
            <td><input type="text" name="birthday"
                       value="<?= $driver->birthday ?>"
                       class="form-control"/></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="text" name="phone" value="<?= $driver->phone ?>" class="form-control"/></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">Водительское удостоверение</td>
        </tr>
        <tr>
            <td>Серия и номер</td>
            <td><input type="text" name="driving_license" value="<?= $driver->driving_license ?>" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td>Дата выдачи</td>
            <td><input type="text" name="data_driving_license"
                       value="<?= $driver->data_driving_license ?>"
                       class="form-control"/></td>
        </tr>

        <tr>
            <td>Категория</td>
            <td>
                <div class="columns" style="columns: 4 auto">
                    <?php
                    $stmt = $category->read();

                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_category);
                        $categoryCheck = in_array($name, json_decode($driver->allowed_category)) ? "checked" : "";
                        echo "<label style='display: block;'><input type='checkbox' name='allowed_category[]' " . $categoryCheck . " value='" . $name . "'>" . $name . "</label>";
                    } ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>Доступные автомобили</td>
            <td>
                <div class="columns" style="columns: 4 auto">
                    <?php
                    $cars = $car->getFreeCars();

                    while ($row_category = $cars->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_category);
                        echo "<label style='display: block;'><input type='checkbox' name='cars[]' value='" . $id . "'>" . $state_number . "</label>";
                    }

                    $cars2 = $car->getBusyCars($id);
                    while ($row_category = $cars2->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_category);
                        echo "<label style='display: block;'><input type='checkbox' name='cars[]' checked value='" . $id . "'>" . $state_number . "</label>";
                    }
                    ?>
                </div>

            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </td>
        </tr>

    </table>
</form>

<?php require "app/layout_footer.php"; ?>
