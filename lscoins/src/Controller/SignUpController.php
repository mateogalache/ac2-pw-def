<?php
declare(strict_types=1);

namespace SallePW\SlimApp\Controller;

use DateTime;
use SallePW\SlimApp\Controller\InputsValidationsController;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SallePW\SlimApp\Model\Repository\MysqlUserRepository;
use SallePW\SlimApp\Model\User;
use SallePW\SlimApp\Model\UserRepository;
use Slim\Views\Twig;

final class SignUpController
{
    private Twig $twig;

    private MysqlUserRepository $mysqlUserRepository;

    public function __construct(Twig $twig, UserRepository $userRepository)
    {
        $this->twig = $twig;
        $this->mysqlUserRepository = $userRepository;
    }

    public function showSignUp(Request $request, Response $response): Response
    {

        return $this->twig->render(
            $response,
            'sign-up.twig'
        );
    }

    public function uploadSignUp(Request $request, Response $response): Response
    {
        $email = $_POST['email'];
        $coins = $_POST['coins'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatPassword'];
        $formData = array (
            'email' => $email,
            'coins' => $coins,
        );

        $validationsController = new InputsValidationsController();

        $formErrors['email'] = $validationsController->emailAction();
        $formErrors['password'] = $validationsController->authPasswordUp($password,$repeatedPassword);
        $formErrors['coins'] = $this->authCoins();

        if(!$formErrors['email'] && !$formErrors['password'] && (!$formErrors['coins'] || !$_POST['coins'])){

            $user = new User(
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['coins'] ?? '',
                new DateTime(),
                new DateTime()
            );
            $this->mysqlUserRepository->save($user);
            return $response->withHeader('Location', '/sign-in')->withStatus(302);
        }
        else{
            return $this->twig->render(
                $response,
                'sign-up.twig',
                [
                    'formAction' => '/sign-up',
                    'formData' => $formData,
                    'formErrors' => $formErrors
                ]
            );
        }

    }
    private function authCoins(): ?string
    {
        if(!filter_var($_POST['coins'], FILTER_VALIDATE_INT)){
            return "The number of LSCoins is not a valid number.";
        }
        else if ($_POST['coins'] < 50 || $_POST['coins'] > 30000){
            return "Sorry, the number of LSCoins is either below or above the limits.";
        }
        else{
            return null;
        }
    }




}