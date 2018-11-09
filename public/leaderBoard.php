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
		<br><br>
		<div class="container">
			<div class="wrapper">
				<table>
					<thead>
						<tr>
							<th>Rank</th>
							<th>Login</th>
							<th>Parties jouées</th>
							<th>Parties gagnées</th>
							<th>Ratio de victoire</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$leaderBoard = $userRepository->findTopTen();
							if(count($leaderBoard)!=0) {
								$rank=1;
								foreach ($leaderBoard as $key => $user) {
									if($leaderBoard[0]!= $user /*&& $user->ratio<$leaderBoard[$key-1]->ratio*/) {
										$rank++;
									}
									$login = $user->login;
									$totGame = $user->totalgames;
									$wins = $user->wins;
									$ratio = $user->ratio;
									echo "<tr><td>$rank</td><td>$login</td><td>$totGame</td><td>$wins</td><td>".round($ratio,2)."</td></tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>

