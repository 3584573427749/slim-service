<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/di.php';
AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/../config/routes.php')($app);

$app->run();
