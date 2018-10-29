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
	<link rel="stylesheet" href="css/histo.css"/>
	
	</head>
	<body>
	<?php require "navBar.php"; ?>
		<div class="container">
			<div class="wrapper">
				<table>
					<thead>
						<tr>
							<th>Date</th>
							<th>Adversaire</th>
							<th>Vos cartes jouées</th>
							<th>Cartes jouées (adversaire)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						$login = $_SESSION["login"];
						$userSession = $userRepository->findOneByLogin($login);
						$games = $gameRepository->fetchAllByUser($userSession);						

						foreach ($games as $key => $game) { 
							$date = $game->getCreatedAt();
							$enemy = $userRepository->findOneById($game->getIdPlayer1() == $userSession->getId() ? $game->getIdPlayer2() : $game->getIdPlayer1());
							$enemyName = $enemy->getLogin();
							$isWinner = $userSession->getId() == $game->getIdWinner() ? true : false;
							echo "<tr class='".($isWinner?"win":"loose")."'><td>$date</td><td>$enemyName</td><td></td><td></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>