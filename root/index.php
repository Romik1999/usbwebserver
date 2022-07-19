<?php

require 'app/Router.php';

$url = explode('?', $_SERVER['REQUEST_URI']);


$r = new Router();

$r->addRoute('/', 'main.php');
$r->addRoute('/drivers', 'drivers/index.php');
$r->addRoute('/drivers/create', 'drivers/create.php');
$r->addRoute('/drivers/update', 'drivers/update.php');
$r->addRoute('/drivers/read', 'drivers/read.php');
$r->addRoute('/drivers/delete', 'drivers/delete.php');
$r->addRoute('/cars', 'cars/index.php');
$r->addRoute('/cars/create', 'cars/create.php');
$r->addRoute('/cars/update', 'cars/update.php');
$r->addRoute('/cars/read', 'cars/read.php');
$r->addRoute('/cars/delete', 'cars/delete.php');

$r->route($url[0]);