<?php

include "config/core.php";

include "config/database.php";
include "objects/driver.php";

$database = new Database();
$db = $database->getConnection();

$product = new Driver($db);

$page_title = "Приложение гараж";

include "layout_header.php";


?>
    Навигация
    <ul>
        <li><a href="/drivers">Водители</a></li>
        <li><a href="/cars">Автомобили</a></li>
    </ul>

<?php include "layout_footer.php";
