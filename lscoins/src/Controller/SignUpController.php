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

        $data = $request->getParsedBody();

        $email = $data['email'];
        $coins = $data['coins'];
        $password = $data['password'];
        $repeatedPassword = $data['repeatPassword'];
        $formData = array (
            'email' => $email,
            'coins' => $coins,
        );

        $validationsController = new InputsValidationsController();

        $formErrors['email'] = $validationsController->emailAction();
        $formErrors['password'] = $validationsController->authPasswordUp($password,$repeatedPassword);
        $formErrors['coins'] = $this->authCoins();

        if(!$formErrors['email'] && !$formErrors['password'] && (!$formErrors['coins'] || !$_POST['coins'])){
            $formErrors['email'] = $this->repeatedEmail();
            if (!$formErrors['email']){
                $user = new User(
                    $data['email'] ?? '',
                    $data['password'] ?? '',
                    $data['coins'] ?? '',
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

    private function repeatedEmail(): ?string
    {
        if ($this->mysqlUserRepository->select()){
            return "The email is already taken.";
        }
        else{
            return null;
        }
    }




}