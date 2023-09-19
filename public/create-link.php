<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Auth;
use Core\Response;
use Core\Shortify\Shortify;
use Rakit\Validation\Validator;

$validator = new Validator();
$shortify = new Shortify();
$auth = new Auth();

$validation = $validator->validate($_POST, [
    'link' => 'required|url'
]);

if ($validation->fails()) {
    $response = new Response('Validation error.', $validation->errors()->toArray(), 422);
    die($response);
}

$data = $validation->getValidatedData();

try {
    $link = $shortify->createLink($data['link'], $auth?->user);
} catch (\Throwable $e) {
    $response = new Response('Something went wrong', [], 500);
    exit($response);
}

exit(new Response('Link was successfully created', [
    'url' => $shortify->url
]));