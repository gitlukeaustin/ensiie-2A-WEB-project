<?php
require '../vendor/autoload.php';
require 'redirect.php';

if (session_status() == PHP_SESSION_NONE) session_start();


//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");


$front = new GameController($connection);

$dispatched = $front->dispatch();
?>
