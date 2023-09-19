<?php

use RedBeanPHP\R;

require __DIR__ . '/vendor/autoload.php';

$db = config['database'];

R::setup("mysql:host={$db['host']};dbname={$db['database']}", $db['username'], $db['password']);

