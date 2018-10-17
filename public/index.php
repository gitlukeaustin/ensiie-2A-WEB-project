<?php
require '../vendor/autoload.php';

//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");

//$userRepository = new \User\UserRepository($connection);
//$users = $userRepository->fetchAll();

$unitRepository = new \Unit\UnitRepository($connection);
$units = $unitRepository->fetchAll();
var_dump($units);
?>

<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h3><?php echo 'Docker! php' . PHP_VERSION; ?></h3>

   
   
</div>
</body>
</html>
