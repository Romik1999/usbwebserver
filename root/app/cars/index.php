<?php
include "app/config/core.php";
include "app/config/database.php";
include "app/objects/car.php";

$database = new Database();
$db = $database->getConnection();

$car = new Car($db);

$page_title = "Раздел автомобили";

include "app/layout_header.php";

$stmt = $car->readAll($from_record_num, $records_per_page);

$page_url = "index.php?";

$total_rows = $car->countAll();

?>
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
        <a class="" href="/" style="display: block">На главную страницу</a>

        <a href="/cars/create" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span> Создать автомомбиль
        </a>
    </div>

<?php

if ($total_rows > 0) {
    ?>
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <th>Марка</th>
            <th>гос. номер</th>
            <th>Год выпуска</th>
            <th>Категория ТС</th>
            <th>Действия</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            ?>

            <tr>
                <td><?= $mark ?></td>
                <td><?= $state_number ?></td>
                <td><?= $year_issue ?></td>
                <td><?= $vehicle_category ?></td>

                <td>
                    <a href="/cars/read/?id=<?= $id ?>"
                       class="btn btn-primary left-margin">
                        <span class="glyphicon glyphicon-list"></span>
                        Просмотр
                    </a>
                    <a href="/cars/update/?id=<?= $id ?>"
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
    <?php include "app/paging.php";
} else {
    echo '<div class="alert alert-danger">Автомобилей не найдено.</div>';
}


include "app/layout_footer.php";
