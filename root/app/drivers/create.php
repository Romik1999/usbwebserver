<?php

include_once "app/config/database.php";
include_once "app/objects/driver.php";
include_once "app/objects/category.php";
include_once "app/objects/car.php";

$database = new Database();
$db = $database->getConnection();

$driver = new Driver($db);
$category = new Category($db);
$car = new Car($db);

$page_title = "Создание водителя";

require_once "app/layout_header.php";

?>

    <div class="right-button-margin">
        <a href="/drivers" class="btn btn-default pull-right">Просмотр всех Водителей</a>
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


    if ($driver->create()) {
        echo '<div class="alert alert-success">Водитель был успешно добавлен.</div>';
    } else {
        echo '<div class="alert alert-danger"><span>Невозможно добавить водителя.</span>';
        foreach ($driver->errors as $attribute => $error) {
            echo '<div>Ошибка ' . $attribute . ' ' . $error . '</div>';
        }
        echo '</div>';
    }
}
?>

    <form action="/drivers/create" method="post">

        <table class="table table-hover table-responsive table-bordered">

            <tr>
                <td>Фамилия</td>
                <td><input type="text" name="surname" required class="form-control"/></td>
            </tr>

            <tr>
                <td>Имя</td>
                <td><input type="text" name="name" required class="form-control"/></td>
            </tr>

            <tr>
                <td>Отчество</td>
                <td><input type="text" name="patronymic" class="form-control"/></td>
            </tr>

            <tr>
                <td>День рождения</td>
                <td><input type="text" name="birthday" required class="form-control"/></td>
            </tr>

            <tr>
                <td>Телефон</td>
                <td><input name="phone" type="tel" required class="form-control"></td>
            </tr>

            <tr>
                <td>Серия и номер водительского удостоверения</td>
                <td><input name="driving_license" class="form-control"></td>
            </tr>

            <tr>
                <td>Дата выдачи водительского удостоверения</td>
                <td><input name="data_driving_license" class="form-control"></td>
            </tr>

            <tr>
                <td>Категория</td>
                <td>
                    <div class="columns" style="columns: 4 auto">
                        <?php
                        $stmt = $category->read();
                        while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_category);
                            echo "<label style='display: block;'><input type='checkbox' name='allowed_category[]' value='" . $name . "'>" . $name . "</label>";
                        } ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Гос. номера машин</td>
                <td>
                    <div class="columns" style="columns: 4 auto">
                        <?php

                        $stmt = $car->readForCreate();

                        while ($row_car = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_car);
                            echo "<label style='display: block;'><input type='checkbox' name='cars[]' value='" . $id . "'>" . $state_number . "</label>";
                        } ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </td>
            </tr>

        </table>
    </form>

<?php
include "app/layout_footer.php";
