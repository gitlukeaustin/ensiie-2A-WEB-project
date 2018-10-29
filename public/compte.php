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
require "navBar.php";

if(isset($_SESSION['login']) && $_SESSION['login'] != null && isset($_SESSION['uniqid']) && $_SESSION['uniqid'] != null){
	$user = $userRepository->findOneByLogin($_SESSION['login']);
}

if(isset($_GET['status']))
	if($_GET['status'] == 'successModify')
		echo "<b> Your informations are successufly modified ! </b>";
	if($_GET['status'] == 'successDelete')
		echo "<b> Your account has been deleted !</b>";

?>


<script type="text/javascript">
	var columns =['login', 'email', 'ects'];

	function enableInputs(){
		for (var i = columns.length - 1; i >= 0; i--) 
				document.getElementById(columns[i]).disabled = false;
		document.getElementById("validate").style="width: 100px;"
		document.getElementById("modify").style="width: 100px; display:none;"
	}

	function validateInputs(){
		var id = document.getElementById("user_id").value;
		var newLogin = document.getElementById("login").value;
		var newEmail = document.getElementById("email").value;
		var newEcts = document.getElementById("ects").value;

		window.location.href="modify.php?login="+newLogin+"&email="+newEmail+"&ects="+newEcts+"&id="+id;
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
	        	<br /><br />
	        	<table>
	        		<tr>
	        			<td>
	        				<form method="POST" action="delete.php">  
				        		<input type="hidden" name='user_id' value='<? echo $user->getId() ?>' >
				        		<input type="submit" class="fadeIn fourth" value="delete" style="width: 100px" >
				        	</form>
	        			</td>
	        			<td>
	        				<form method="POST" action="compte.php">
				        		<input type="hidden" id='user_id' value='<?php echo $user->getId() ?>' >
					        	<input type="button" id='modify' onclick="enableInputs()" class="fadeIn fourth" value="modify" style="width: 100px" >
					        	<input type="button" id='validate' onclick="validateInputs()" class="fadeIn fourth" value="validate" style="width: 100px; display: none;" >
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
