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

$page_title = "Обновление товара";

include "app/layout_header.php";
?>

<div class="right-button-margin">
    <a href="/cars" class="btn btn-default pull-right">Просмотр всех автомобилей</a>
</div>

<?php

if ($_POST) {

    $car->mark = $_POST["mark"];
    $car->state_number = $_POST["state_number"];
    $car->year_issue = $_POST["year_issue"];
    $car->chassis_number = $_POST["chassis_number"];
    $car->body_number = $_POST["body_number"];
    $car->vehicle_category = $_POST["vehicle_category"];


    if ($car->update()) {
        echo "<div class='alert alert-success alert-dismissable'>Товар был обновлён.</div>";
    } else {
        echo "<div class='alert alert - danger alert - dismissable'>Невозможно обновить товар.</div>";
    }
}
?>

<form action="/cars/update?id=<?= $id ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">

        <tr>
            <td>Марка</td>
            <td><input type="text" name="mark" class="form-control" value="<?= $car->mark ?>"/></td>
        </tr>

        <tr>
            <td>Гос. номер</td>
            <td><input type="text" name="state_number" class="form-control" value="<?= $car->state_number ?>"/></td>
        </tr>

        <tr>
            <td>Год выпуска</td>
            <td><input type="text" name="year_issue" class="form-control" value="<?= $car->year_issue ?>"/></td>
        </tr>

        <tr>
            <td>Номер шасси</td>
            <td><input name="chassis_number" class="form-control" value="<?= $car->chassis_number ?>"></td>
        </tr>

        <tr>
            <td>Номер кузова</td>
            <td><input name="body_number" class="form-control" value="<?= $car->body_number ?>"></td>
        </tr>
        <tr>
            <td>Категория ТС</td>
            <td>
                <div class="columns" style="columns: 4 auto">
                    <?php
                    $stmt = $category->read();
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_category);
                        $carCAtegoryCheck = ($name == $car->vehicle_category) ? "checked" : "";
                        echo "<label style='display: block;'><input type='radio' name='vehicle_category' " . $carCAtegoryCheck . "  value='" . $name . "'>" . $name . "</label>";
                    } ?>
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
