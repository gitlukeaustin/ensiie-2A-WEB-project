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

<html>
<link href="../css/login.css" rel="stylesheet"></link>
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
	            <b>Login : <input type="text" id="login" class="fadeIn second" style="width: 200px;" name="login" value="<? echo $user->getLogin() ?>" placeholder="username" disabled="true" />
	            <br />
	            Email : <input type="text" id="email" class="fadeIn third" style="width: 200px;" name="email"  value="<? echo $user->getEmail() ?>" placeholder="email" disabled="true">
	            <br />
	            Ects : &nbsp; <input type="text" id="etcs" class="fadeIn third" style="width: 200px;" name="ects"  value="<? echo $user->getEcts() ?>" placeholder="ects" disabled="true">
	        	</b>
	        	<form method="POST" action="delete.php">  
	        		<input type="hidden" name='user_id' value='<? echo $user->getId() ?>' >
	        		<input type="submit" class="fadeIn fourth" value="delete" style="width: 80px;" >
	        	</form>

	        	<form method="POST" action="modify.php">
		        	<input type="submit" class="fadeIn fourth" value="modify" >
	        	</form>
        <?php } ?>


        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#">Go to the Site</a>
        </div>

    </div>
</div>

</html>