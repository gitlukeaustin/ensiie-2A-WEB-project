<?php
require '../vendor/autoload.php';

use Game\GameRepository;

//postgres
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new \User\UserRepository($connection);
$gameRepository = new \Game\GameRepository($connection);
@ob_start();
session_start();
?>

<html>
	<head>
	<link rel="stylesheet" href="css/default.css"/>
	<link rel="stylesheet" href="css/histo.css"/>
	</head>
	<body>
		<div id='histo'>
			<?php
			readfile("html/navBar.html");
			$login = "kevin";
			$userSession = $userRepository->findOneByLogin($login);
			$games = $gameRepository->fetchAllByUser($userSession);
			foreach ($games as $key => $game) { 
				$date = $game->getCreatedAt();
				$enemy = $userRepository->findOneById($game->getIdPlayer1() == $userSession->getId() ? $game->getIdPlayer2() : $game->getIdPlayer1());
				$enemyName = $enemy->getLogin();
				$isWinner = $userSession->getId() == $game->getIdWinner() ? true : false;
				echo "<div class='histoGame ".($isWinner?"win":"loose")."'>";
				echo "<div class='date'>Partie jouée le $date</div>";
				echo "<div class='players '>$login <img src='image/vs.png' height='40px' width='40px'/> $enemyName</div>";

				echo "</div>";
			}
			?>
		</div>
	</body>
</html>