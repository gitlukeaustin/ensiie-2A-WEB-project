<head>
	<link href='../css/default.css' rel="stylesheet">
</head>

<header>
	<nav>	
		<div class="nav-block">
			<div>
				<a href="index.php"><span class='title'>Our game</span></a>
			</div>
			<div>
			<a href="index.php">Accueil</a>
				<a href="jeu.php">Jeu</a>
				<a href="index.php">Guide</a>
				<a href="leaderBoard.php">Classement</a>
				<?php
					if(isset($_SESSION["login"]) && isset($_SESSION["uniqid"])) {
					 echo '<a href="compte.php">'.$_SESSION["login"].'</a>';
					}
				?>
			</div>
		</div>		
    </nav> 
    <br>
</header>