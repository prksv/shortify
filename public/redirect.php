<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Response;
use Core\Shortify\Shortify;

$shortify = new Shortify();

$uuid = $_GET['uuid'];

$link = $shortify->findLink($uuid);

if (!$link) {
    include '../views/404.php';
    die();
}

$shortify->increaseViews($link);

header("Location: {$link->url}");
exit();