<?php

$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");

require '../vendor/autoload.php';
if(!isset($_SESSION)) session_start();

$frontController = new \FrontController($connection);

$frontController->dispatch();



/*use User\UserRepository;

$userRepository = new UserRepository($connection);
$userHydrator = new \User\UserHydrator();
@ob_start();




require 'navBar.php';

if(isset($_SESSION['uniqid']) && isset($_SESSION['login'])){
    echo '<html>';
    readfile('navBar.php');
    echo '<body>';
    readfile('html/jeu.html');
    echo '<body></html>';
}
else{
    readfile("html/login.php");
}
*/

?>