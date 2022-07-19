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

$page_title = "Страница товара (чтение одного товара)";

require_once "layout_header.php";
?>

    <div class="right-button-margin">
        <a href="../index.php" class="btn btn-primary pull-right">
            <span class="glyphicon glyphicon-list"></span> Просмотр всех товаров
        </a>
    </div>

    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Название</td>
            <td><?= $product->name ?></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td><?= $product->price ?></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><?= $product->description ?></td>
        </tr>
        <tr>
            <td>Категория</td>
            <td>
                <?php
                $category->id = $product->category_id;
                $category->readName();
                echo $category->name;
                ?>
            </td>
        </tr>
    </table>

<?php require_once "layout_footer.php"; ?>