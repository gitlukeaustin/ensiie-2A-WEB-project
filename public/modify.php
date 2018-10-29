<?php
require '../vendor/autoload.php';
use User\UserRepository;
#Data
$id = $_GET["id"];
$login = $_GET["login"];
$email = $_GET["email"];
$ects = $_GET["ects"];

#Repo
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new UserRepository($connection);

#Session
session_start();

if(isset($id) && isset($login) && isset($email) && isset($ects)){

	$userRepository->modifyUserById($id, $login, $email, $ects);
	$_SESSION['login'] = $login;
	$_SESSION['email'] = $email;
	$_SESSION['ects'] = $ects;

}

header('Location: /compte.php?status=successModify');

?>