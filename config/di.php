<?php
declare(strict_types=1);

use App\Application\ErrorHandler\ErrorHandler;
use App\Application\ErrorHandler\ErrorMiddleware;
use App\Application\Settings;
use DI\ContainerBuilder;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions(
        [Settings::class => fn() => Settings::getInstance(),
            'logger' => fn() => (require __DIR__ . '/logger.php')(),
            ErrorHandler::class => fn($c) => new ErrorHandler($c->get('logger')),
            ErrorMiddleware::class => fn($c) => new ErrorMiddleware($c->get(ErrorHandler::class)),
        ]);
};
