<?php
require '../vendor/autoload.php';
use User\UserRepository;
#Data
$id = $_GET["id"];
$login = $_GET["login"];
$email = $_GET["email"];

#Repo
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new UserRepository($connection);

#Session
session_start();

if(isset($id) && isset($login) && isset($email) ){

	$userRepository->modifyUserById($id, $login, $email);
	$_SESSION['login'] = $login;
	$_SESSION['email'] = $email;

}

header('Location: /compte/successModify');

?>