<?php
?>
    <form role="search" action="search.php">
        <div class="input-group col-md-3 pull-left margin-right-1em">
            <?php $search_value = isset($search_term) ? 'value="' . $search_term . '"' : ""; ?>
            <input type="text" class="form-control" placeholder="Введите название или описание продукта ..." name="s"
                   id="srch-term" required <?= $search_value ?>/>
            <div class="input-group-btn">
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
    </form>
    <div class="right-button-margin">
        <a href="create_product.php" class="btn btn-primary pull-right">
            <span class="glyphicon glyphicon-plus"></span> Создать товар
        </a>
    </div>
<?php

if ($total_rows > 0) {
    ?>
    <table class="table table - hover table - responsive table - bordered">
        <tr>
            <th>Товар</th>
            <th>Цена</th>
            <th>Описание</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            ?>

            <tr>
                <td><?= $name ?></td>
                <td><?= $price ?></td>
                <td><?= $description ?></td>
                <td>
                    <?php
                    $category->id = $category_id;
                    $category->readName();
                    echo $category->name; ?>
                </td>

                <td>
                    <a href="read_product.php?id=<?= $id ?>"
                       class="btn btn-primary left-margin">
                        <span class="glyphicon glyphicon-list"></span>
                        Просмотр
                    </a>
                    <a href="update_product.php?id=<?= $id ?>"
                       class="btn btn-info left-margin">
                        <span class="glyphicon glyphicon-edit"></span>
                        Редактировать
                    </a>
                    <a delete-id="<?= $id ?>"
                       class="btn btn-danger delete-object">
                        <span class="glyphicon glyphicon-remove"></span>
                        Удалить
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php include_once "paging.php";
} else {
    echo '<div class="alert alert - danger">Товаров не найдено.</div>';
} ?>