<?php
declare(strict_types=1);

namespace SallePW\SlimApp\Controller;

use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class ChangePasswordController
{


    public function __construct(
        private Twig $twig,
        private Messages $flash)
    {
    }

    public function showChangePassword(Request $request, Response $response): Response
    {

        if(!isset($_SESSION['username'])){
            $this->flash->addMessage(
                'notifications',
                'You must be logged in to access the changePassword page.'
            );

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor("sign-in"))
                ->withStatus(302);
        } else{
            return $this->twig->render(
                $response,
                'changePassword.twig'
            );
        }



    }





}