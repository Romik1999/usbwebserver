<?php
$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/category.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$category = new Category($db);

$product->id = $id;

$product->readOne();

$page_title = "Обновление товара";

include_once "layout_header.php";
?>

    <div class="right-button-margin">
        <a href="../index.php" class="btn btn-default pull-right">Просмотр всех товаров</a>
    </div>

<?php

if ($_POST) {

    $product->name = $_POST["name"];
    $product->price = $_POST["price"];
    $product->description = $_POST["description"];
    $product->category_id = $_POST["category_id"];

    if ($product->update()) {
        echo "<div class='alert alert-success alert-dismissable'>Товар был обновлён.</div>";
    } else {
        echo "<div class='alert alert - danger alert - dismissable'>Невозможно обновить товар.</div>";
    }
}
?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
        <table class="table table-hover table-responsive table-bordered">

            <tr>
                <td>Название</td>
                <td><input type="text" name="name" value="<?= $product->name ?>" class="form-control"/></td>
            </tr>

            <tr>
                <td>Цена</td>
                <td><input type="text" name="price" value="<?= $product->price ?>" class="form-control"/></td>
            </tr>

            <tr>
                <td>Описание</td>
                <td><textarea name="description" class="form-control"><?= $product->description ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Категория</td>
                <td>
                    <?php
                    $stmt = $category->read(); ?>
                    <select class="form - control" name="category_id">
                        <option>Пожалуйста выберите...</option>
                        <?php
                        while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $category_id = $row_category["id"];
                            $category_name = $row_category["name"];

                            if ($product->category_id == $category_id) {
                                echo '<option value="' . $category_id . '" selected>';
                            } else {
                                echo '<option value="' . $category_id . '">';
                            }

                            echo $category_name . "</option>";
                        } ?>
                    </select>
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

<?php require_once "layout_footer.php"; ?>
