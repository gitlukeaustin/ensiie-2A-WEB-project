<?php
require '../vendor/autoload.php';

//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new \User\UserRepository($connection);
$userHydrator = new \User\UserHydrator();
@ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['disconnect'])){
        session_destroy();
        session_start();
        header('Location: http://localhost:8080');
        exit();
    }

    $login = $_POST['login'];
    $password = $_POST['password'];

    $view = [
            'user' => [
                    'login' => $login ?? null,
                    'password' => $password ?? null,
            ],
        'errors' => [],
    ];

    if($login && $password){
        $user = $userRepository->findOneByLogin($login);
        if(!$user){
            $view['errors']['not_exists'] = 'Utilisateur inexistant.';
        }
        else {

            if ($password === $user->getPassword()) {
                $_SESSION['uniqid'] = uniqid();
                $_SESSION['login'] = $login;
                $_SESSION['user'] = $userHydrator->extract($user);
            } else {
                $view['errors']['wrong_password'] = 'Le mot de passe entré n\'est pas le bon.';
            }
        }
        } else{
        /* Validation dynamique en JS, ce cas ne devrait pas arriver */
            $view['errors']['not_set'] = 'Veuillez remplir tous les champs.';
         }

        if(count($view['errors']) === 0){
            header('Location: http://localhost:8080/jeu.php');
        }

        print_r($view['errors']);
    }

?>
