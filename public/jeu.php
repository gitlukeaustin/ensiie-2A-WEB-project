<?php
require '../vendor/autoload.php';

//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");

//$userRepository = new \User\UserRepository($connection);
//$users = $userRepository->fetchAll();

//$unitRepository = new \Unit\UnitRepository($connection);
//$units = $unitRepository->fetchAll();
//var_dump($units);
//$catRepo = new \Category\CategoryRepository($connection);
//$cats = $catRepo->fetchAll();
//var_dump($cats);

$front = new FrontController($connection);

$dispatched = $front->dispatch();


    if(!$dispatched): ?>

    <html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/jeu.css?ver=1">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <!-- production version, optimized for size and speed
        <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
        <script type="text/javascript" src="js/jeu.js?ver=1" ></script>
    </head>
    <body>

    <div class="container">


        <?php readfile("html/jeu.html"); ?>

    </div>
    </body>
    </html>

    <?php endif ?>
