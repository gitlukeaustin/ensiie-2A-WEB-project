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
if (session_status() == PHP_SESSION_NONE) session_start();

?>

<html>
	<?php require "navBar.php"; ?>
	<body>

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

							//selection des cartes
							$cardsUsers = json_decode($game->getCards(),true);
							$count=array();
							if(count($cardsUsers)!=0) {
								foreach ($cardsUsers as $key => $cardsUser) {
									if(count($cardsUser)!=1) {
										foreach ($cardsUser as $key2 => $card) {
											if(!empty($count[$key][$card['name']]))
												$count[$key][$card['name']]++;
											else
												$count[$key][$card['name']]=1;
										}
									}
								}
							}
							$listCards = array();
							$listCards[$login] = "";
							$listCards[$enemyName] = "";
							if(count($count)!=0) {
								foreach ($count as $key => $user) {
									foreach ($user as $nom => $countCard) {
										$listCards[$key].=$countCard."X<img width='22px' height='22px' src='image/".strtolower($nom).".png'/> ";
									}
								}
							}

							//Affichage des lignes
							echo "<tr class='".($isWinner?"win":"loose")."'><td>$date</td><td>$enemyName</td><td>".$listCards[$login]."</td><td>".$listCards[$enemyName]."</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>