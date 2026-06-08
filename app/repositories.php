<?php

use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Repository-mappningar
    $containerBuilder->addDefinitions([
//       UserRepository::class => autowire(DbalUserRepository::class),
    ]);
};
