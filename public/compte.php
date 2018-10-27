<?php
require '../vendor/autoload.php';
use User\UserRepository;

$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$connection = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
$userRepository = new UserRepository($connection);
$userHydrator = new \User\UserHydrator();
@ob_start();
session_start();
readfile("html/navBar.html");


if(isset($_SESSION['login']) && $_SESSION['login'] != null && isset($_SESSION['uniqid']) && $_SESSION['uniqid'] != null){
	$user = $userRepository->findOneByLogin($_SESSION['login']);
}




?>
<script type="text/javascript">
	var columns = ["login", "email", "ects"];

	window.onload = function () {
		for(index in columns)
			document.getElementById(columns[index]).disabled = false;
	};

	function enableInputs(login, email, ects){
		login.disabled = true;
		email.disabled = false;
		ects.disabled = false;
	}
</script>



<html>
<link href="../css/compte.css" rel="stylesheet"></link>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <br /><br />

        <div class="fadeIn first">
            <h1>Account Information</h1>
        </div>

        <br /><br />

        <?php if(isset($_SESSION['login']) && $_SESSION['login'] != null) { ?>
	            <b>Login : <input type="text" id="login" class="fadeIn second" style="width: 200px;" name="login" value="<? echo $user->getLogin() ?>" placeholder="username" disabled />
	            <br />
	            Email : <input type="text" id="email" class="fadeIn third" style="width: 200px;" name="email"  value="<? echo $user->getEmail() ?>" placeholder="email" disabled />
	            <br />
	            Ects : &nbsp; <input type="text" id="ects" class="fadeIn third" style="width: 200px;" name="ects"  value="<? echo $user->getEcts() ?>" placeholder="ects" disabled />
	        	</b>
	        	<br /><br /><br />
	        	<table>
	        		<tr>
	        			<td>
	        				<form method="POST" action="delete.php">  
				        		<input type="hidden" name='user_id' value='<? echo $user->getId() ?>' >
				        		<input type="submit" class="fadeIn fourth" value="delete" style="width: 100px;text-align: center" >
				        	</form>
	        			</td>
	        			<td>
	        				<form method="POST" action="compte.php">
				        		<input type="hidden" name='_user_id' value='<? echo $user->getId() ?>' >
					        	<input type="submit" class="fadeIn fourth" value="modify" style="width: 100px;text-align: center" >
				        	</form>
	        			</td>
	        		</tr>
	        	</table>

        <?php } ?>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#">Go to the Site</a>
        </div>

    </div>
</div>
</html>

<?php

if(isset($_POST['_user_id']))
{
   modify();
} 

function modify(){
    echo "modify " . $_POST["_user_id"]. '<script type="text/javascript"> enableInputs(document.getElementById("login"), document.getElementById("email"), document.getElementById("ects")); </script>';
}

?>
