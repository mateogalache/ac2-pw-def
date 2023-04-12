<?php
declare(strict_types=1);

namespace SallePW\SlimApp\Controller;

final class InputsValidationsController{

    public function emailAction(): string|null
    {

        $email = $_POST['email'];

            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                return "The email address is not valid.";
            }
            else if (!str_ends_with($email, "@salle.url.edu")){
                return "Only emails from the domain @salle.url.edu are accepted.";
            }
            else{
                return null;
            }
    }


    public function authPassword(string $password): ?string
    {
        if(!preg_match('/^.{7,}$/', $password)){
            return "The password must contain at least 7 characters.";
        }

        else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',$password)){
            return "The password must contain both upper and lower case letters and numbers.";
        }

        else{
            return null;
        }
    }

    public function authPasswordUp(string $password, string $repeatedPassword): ?string
    {
        if($password !== $repeatedPassword){
            return "Passwords do not match.";
        }

        else if(!preg_match('/^.{7,}$/', $password)){
            return "The password must contain at least 7 characters.";
        }

        else if(!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',$password)){
            return "The password must contain both upper and lower case letters and numbers.";
        }

        else{
            return null;
        }
    }



}