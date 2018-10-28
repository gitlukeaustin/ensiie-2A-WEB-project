<?php
require '../vendor/autoload.php';

use User\UserRepository;

$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new UserRepository($connection);
$userHydrator = new \User\UserHydrator();
@ob_start();
session_start();
require 'navBar.php';

if(isset($_SESSION['uniqid']) && isset($_SESSION['login'])){
    header('Location: http://localhost:8080/jeu.php');
    exit();
}
else{
    readfile("html/login.html");
}
?>