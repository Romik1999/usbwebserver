<?php

include_once "config/database.php";
include_once "objects/driver.php";

$database = new Database();
$db = $database->getConnection();

$product = new Driver($db);

$page_title = "Создание водителя";

require_once "layout_header.php";
?>

    <div class="right-button-margin">
        <a href="/" class="btn btn-default pull-right">Просмотр всех Водителей</a>
    </div>

<?php

if ($_POST) {

    $product->name = $_POST["surname"];
    $product->name = $_POST["name"];
    $product->name = $_POST["patronymic"];
    $product->name = $_POST["birthday"];
    $product->name = $_POST["phone"];
    $product->name = $_POST["driving_license"];
    $product->name = $_POST["data_driving_license"];
    $product->name = $_POST["allowed_category"];
    $product->name = $_POST["number_car"];


    if ($product->create()) {
        echo '<div class="alert alert-success">Товар был успешно создан.</div>';
    } else {
        echo '<div class="alert alert-danger">Невозможно создать товар.</div>';
    }
}
?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <table class="table table-hover table-responsive table-bordered">

            <tr>
                <td>Surname</td>
                <td><input type="text" name="surname" class="form-control"/></td>
            </tr>

            <tr>
                <td>Name</td>
                <td><input type="text" name="name" class="form-control"/></td>
            </tr>

            <tr>
                <td>Patronymic</td>
                <td><input type="text" name="patronymic" class="form-control"/></td>
            </tr>

            <tr>
                <td>birthday</td>
                <td><input type="text" name="birthday" class="form-control"/></td>
            </tr>

            <tr>
                <td>phone</td>
                <td><textarea name="phone" class="form-control"></textarea></td>
            </tr>

            <tr>
                <td>driving_license</td>
                <td><textarea name="driving_license" class="form-control"></textarea></td>
            </tr>

            <tr>
                <td>data_driving_license</td>
                <td><textarea name="data_driving_license" class="form-control"></textarea></td>
            </tr>

            <tr>
                <td>allowed_category</td>
                <td><textarea name="allowed_category" class="form-control"></textarea></td>
            </tr>

            <tr>
                <td>number_car</td>
                <td><textarea name="number_car" class="form-control"></textarea></td>
            </tr>

<!--            <tr>-->
<!--                <td>Категория</td>-->
<!--                <td>-->
<!--                    --><?php
//                    $stmt = $category->read();
//                    ?>
<!--                    <select class='form - control' name='category_id'>-->
<!--                        <option>Выбрать категорию...</option>-->
<!--                        --><?php
//                        while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                            extract($row_category);
//                            echo "<option value='" . $id . "'>" . $name . "</option>";
//                        } ?>
<!--                    </select>-->
<!--                </td>-->
<!--            </tr>-->

            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </td>
            </tr>

        </table>
    </form>

<?php require_once "layout_footer.php"; ?>