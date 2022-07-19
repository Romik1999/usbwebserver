<?php
include "app/config/core.php";
include "app/config/database.php";
include "app/objects/driver.php";
include "app/objects/car.php";

$database = new Database();
$db = $database->getConnection();

$driver = new Driver($db);
$car = new Car($db);

$page_title = "Раздел Водители";

include "app/layout_header.php";

$stmt = $driver->readAll($from_record_num, $records_per_page);

$page_url = "index.php?";

$total_rows = $driver->countAll();

?>

    <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
        <a class="" href="/" style="display: block">На главную страницу</a>

        <a href="/drivers/create" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span> Создать водителя
        </a>
    </div>
<?php

if ($total_rows > 0) {
    ?>
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Телефон</th>
            <th>Гос номера дотупных машин</th>
            <th>Действия</th>
        </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            ?>

            <tr>
                <td><?= $surname . ' ' . $name . ' ' . $patronymic ?></td>
                <td><?= DateTime::createFromFormat('Y-m-d', $birthday)->format('d-m-Y') ?></td>
                <td><a href="tel:<?= $phone ?>"><?= $phone ?></a></td>
                <td><?= $state_number ?></td>

                <td>
                    <a href="/drivers/read?id=<?= $id ?>"
                       class="btn btn-primary left-margin">
                        <span class="glyphicon glyphicon-list"></span>
                        Просмотр
                    </a>
                    <a href="/drivers/update?id=<?= $id ?>"
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
    echo '<div class="alert alert-danger">Водителей не найдено.</div>';
}

include "app/layout_footer.php";
