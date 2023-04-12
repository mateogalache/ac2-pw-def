<?php
declare(strict_types=1);

namespace SallePW\SlimApp\Controller;

use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

final class HomePageController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showHomePage(Request $request, Response $response): Response
    {
        //session_start();
        if(!isset($_SESSION['username'])){
            $username = "stranger";
        } else{
            $username = $_SESSION['username'];
        }


        return $this->twig->render(
            $response,
            'homepage.twig',
            [
                "username" => $username
            ]
        );
    }





}