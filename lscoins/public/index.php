<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();

$dotenv->load(__DIR__ . '/../.env');

require_once __DIR__ . '/../config/dependencies.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app)); //renderiza html middleware de salida (se ejecuta despues del controlador)

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

$app->addBodyParsingMiddleware();

require_once __DIR__ . '/../config/routing.php';

$app->run();
