<?php

use Core\Auth;
use Core\Response;
use Core\Shortify\Shortify;

require __DIR__ . '/../vendor/autoload.php';

$auth = new Auth();
$shortify = new Shortify();

if (!$auth->check()) {
    die(new Response('Not authorized', [], 401));
}

$links = $shortify->getLinks($auth->user->id);

echo new Response('Links list', $links);
