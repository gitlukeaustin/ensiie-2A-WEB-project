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
if (session_status() == PHP_SESSION_NONE) session_start();


if(isset($_SESSION['login']) && $_SESSION['login'] != null && isset($_SESSION['uniqid']) && $_SESSION['uniqid'] != null)
	$user = $userRepository->findOneByLogin($_SESSION['login']);



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

	function display_historique(){
		window.location.href="/historique";
	}

</script>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->
		<?php echo $log??'' ?>
        <!-- Icon -->
        <br />

        <div class="fadeIn first">
            <h3>Account Information</h3>
        </div>


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
	        				<form method="POST" action="/delete">  
				        		<input type="hidden" name='user_id' value='<? echo $user->getId() ?>' >
				        		<input type="submit" class="fadeIn fourth" value="delete" style="width: 100px" >
				        	</form>
	        			</td>
	        			<td>
	        				<form method="POST" action="/compte">
				        		<input type="hidden" id='user_id' value='<?php echo $user->getId() ?>' >
					        	<input type="button" id='modify' onclick="enableInputs()" class="fadeIn fourth" value="modify" style="width: 100px" >
					        	<input type="button" id='validate' onclick="validateInputs()" class="fadeIn fourth" value="validate" style="width: 100px; display: none;" >
					        	<input type="button" id='historique' class="fadeIn fourth" value="Historique" onclick="display_historique()" style="width: 100px;" >
				        	</form>
				        	
	        			</td>
	        		</tr>
	        	</table>

        <?php } ?>

    

    </div>
</div>

