<?php
declare(strict_types=1);

use SallePW\SlimApp\Controller\ChangePasswordController;
use SallePW\SlimApp\Controller\HomePageController;
use SallePW\SlimApp\Controller\MarketController;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\SignInController;
use SallePW\SlimApp\Controller\SignUpController;
use SallePW\SlimApp\Middleware\beforeMiddleware;
use SallePW\SlimApp\Middleware\StartSessionMiddleware;


$app->add(StartSessionMiddleware::class);

$app->get(
    '/sign-up',
    SignUpController::class . ':showSignUp'
);

$app->post(
    '/sign-up',
    SignUpController::class . ':uploadSignUp'
);

$app->get(
    '/sign-in',
    SignInController::class . ':showSignIn'
)->setName('sign-in');

$app->post(
    '/sign-in',
    SignInController::class . ':uploadSignIn'
);

$app->get(
    '/',
    HomePageController::class . ':showHomePage'
)->setName('home');;

$app->get(
    '/market',
    MarketController::class . ':showMarket'
);

$app->get(
    '/profile/changePassword',
    ChangePasswordController::class . ':showChangePassword'
);

$app->get(
    '/profile',
    ProfileController::class . ':showProfile'
);

