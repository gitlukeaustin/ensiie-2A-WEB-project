<head>
	<base href="/">
	<link href='https://fonts.googleapis.com/css?family=Eater' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Frijole' rel='stylesheet' type='text/css'>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<!-- production version, optimized for size and speed
	<script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
	
	<link rel="stylesheet" href="../css/default.css">

	<?php foreach($headers??[] as $src){ echo $src; }?>

</head>

<header>
	<nav>	
		<div class="nav-block">
			<div>
				<a href="/jeu"><span class='title'>Fight for ENSIIE</span></a>
			</div>
			<div>				
				<a href="/jeu">Jeu</a>
				<a href="/guide">Guide</a>
				<a href="/leaderboard">Classement</a>
				<?php
					if(isset($_SESSION["login"]) && isset($_SESSION["uniqid"])) {
					 		echo '<a href="/compte">'.$_SESSION["login"].'</a>';
					 	
					}
				?>
                <?php if(isset($_SESSION["login"]) && isset($_SESSION["uniqid"])) { ?>
                <a href="login/disconnect">
                	<img id='disconnect' width = "28px" height="28px" src='image/disconnect.png'/>                    
                </a>
                <?php } ?>
			</div>
		</div>		
    </nav>
    <br>
</header>
