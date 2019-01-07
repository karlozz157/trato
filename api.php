<?php

require __DIR__ . '/vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c   = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$app->get('/contract/{contractId}', \Prexto\Controller\ContractController::class . ':index');
$app->post('/contract/{contractId}', \Prexto\Controller\ContractController::class . ':post');

$app->run();
