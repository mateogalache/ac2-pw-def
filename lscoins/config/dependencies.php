<?php
declare(strict_types=1);

use DI\Container;
use Psr\Container\ContainerInterface;
use SallePW\SlimApp\Controller\ChangePasswordController;
use SallePW\SlimApp\Controller\HomePageController;
use SallePW\SlimApp\Controller\MarketController;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\SignInController;
use SallePW\SlimApp\Controller\SignUpController;
use SallePW\SlimApp\Model\Repository\MysqlUserRepository;
use SallePW\SlimApp\Model\Repository\PDOSingleton;
use SallePW\SlimApp\Model\UserRepository;
use Slim\Views\Twig;
use Slim\Flash\Messages;

$container = new Container();

$container->set(
    'view',
    function () {
        return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    },

);

$container->set(
    'flash',
    function () {
        return new Messages();
    }
);

$container->set('db', function () {
    return PDOSingleton::getInstance(
        $_ENV['MYSQL_ROOT_USER'],
        $_ENV['MYSQL_ROOT_PASSWORD'],
        $_ENV['MYSQL_HOST'],
        $_ENV['MYSQL_PORT'],
        $_ENV['MYSQL_DATABASE']
    );
});

$container->set(UserRepository::class, function (ContainerInterface $container) {
    return new MySQLUserRepository($container->get('db'));
});

$container->set(
    SignUpController::class,
    function (Container $c) {
        $controller = new SignUpController($c->get("view"),$c->get(UserRepository::class));
        return $controller;
    }
);

$container->set(
    SignInController::class,
    function (Container $c) {
        $controller = new SignInController($c->get("view"),$c->get("flash"),$c->get(UserRepository::class));
        return $controller;
    }
);

$container->set(
    HomePageController::class,
    function (Container $c) {
        $controller = new HomePageController($c->get("view"));
        return $controller;
    }
);

$container->set(
    ChangePasswordController::class,
    function (Container $c) {
        $controller = new ChangePasswordController($c->get("view"), $c->get("flash"));
        return $controller;
    }
);

$container->set(
    MarketController::class,
    function (Container $c) {
        $controller = new MarketController($c->get("view"), $c->get("flash"));
        return $controller;
    }
);

$container->set(
    ProfileController::class,
    function (Container $c) {
        $controller = new ProfileController($c->get("view"), $c->get("flash"));
        return $controller;
    }
);



