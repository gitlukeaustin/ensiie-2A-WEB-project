<?php

use User\UserHydrator;

require '../vendor/autoload.php';

//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new \User\UserRepository($connection);
$userHydrator = new UserHydrator();
@ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /* Login */
    if(!isset($_POST['registerUsername'])) {
        $login = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        $view = [
            'user' => [
                'login' => $login ?? null,
                'password' => password_hash($_POST['loginPassword'], PASSWORD_DEFAULT) ?? null,
            ],
            'errors' => [],
        ];

        if ($login && $password) {
            $user = $userRepository->findOneByLogin($login);
            if (!$user) {
                $view['errors']['not_exists'] = 'Utilisateur inexistant.';
            } else {

                if (password_verify($password, $user->getPassword())) {
                    $_SESSION['uniqid'] = uniqid();
                    $_SESSION['login'] = $login;
                    $_SESSION['user'] = $userHydrator->extract($user);
                } else {
                    $view['errors']['wrong_password'] = 'Le mot de passe entré n\'est pas le bon.';
                }
            }
        } else {
            /* Validation dynamique en JS, ce cas ne devrait pas arriver */
            $view['errors']['not_set'] = 'Veuillez remplir tous les champs.';
        }
    }
    else{
        /* Register */
        $login = $_POST['registerUsername'];
        $password = $_POST['registerPassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_POST['registerEmail'];
        $confirmPassword = $_POST['registerConfirmPassword'];

        $view = [
            'user' => [
                'login' => $login ?? null,
                'password' => $hashed_password ?? null,
                'email' => $email ?? null,
                'isAdmin' => 0,
                'ects' => 0,
                'isActif' => 1,
            ],
            'errors' => [],
        ];

            $user = $userRepository->findOneByLogin($login);
            if ($user) {
                $view['errors']['not_exists'] = 'Utilisateur déjà présent.';
            } else {
                if ($password === $confirmPassword) {
                    $newUser = new \User\User();
                    $userHydrator->hydrate($view['user'], $newUser);
                    $userRepository->create($newUser);
                    $_SESSION['uniqid'] = uniqid();
                    $_SESSION['login'] = $login;
                    $_SESSION['user'] = $userHydrator->extract($newUser);
                } else {
                    $view['errors']['wrong_password'] = 'Le mot de passe entré n\'est pas le bon.';
                }
            }
    }
    } else {
            /* Validation dynamique en JS, ce cas ne devrait pas arriver */
            $view['errors']['not_set'] = 'Veuillez remplir tous les champs.';
        }

            if(count($view['errors']) === 0){
                header('Location: http://localhost:8080/jeu');
            }

            print_r($view['errors']);


?>
