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

$id = isset($_POST['id'])?$_POST['id']:$_POST['user_id'];
$userRepository->deleteUserById($id);


$_SESSION['login'] = array();
session_destroy();

header("location: login/successDelete");
?>