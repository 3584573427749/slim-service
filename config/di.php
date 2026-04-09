<?php
use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    Settings::class => fn() => Settings::getInstance(),

]);

return $builder->build();
