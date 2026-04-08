<?php
use Slim\App;
use App\Application\Actions\ExampleAction;

return function (App $app) {
    $app->get('/health', ExampleAction::class);
};
