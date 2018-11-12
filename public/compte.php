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
	var columns =['login', 'email'];

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

		window.location.href="modify.php?login="+newLogin+"&email="+newEmail+"&id="+id;
	}

	function display_historique(){
		window.location.href="/historique";
	}

</script>

<div class="flexrow">
	<?php if($user->isAdmin()):?>		
		<div class="wrapper_admin fadeInDown">
	<?endif; 
	if(!$user->isAdmin()): ?>
		<div class="wrapper fadeInDown">
	<?php endif?>
		<div id="formContent">
			<!-- Tabs Titles -->

			<!-- Icon -->
			<br />

			<div class="fadeIn first">
				<h3>Account information</h3>
			</div>


			<?php if(isset($_SESSION['login']) && $_SESSION['login'] != null) { ?>
					
					<b>Login : <input type="text" id="login" class="fadeIn second" style="width: 200px;" name="login" value="<? echo $user->getLogin() ?>" placeholder="username" disabled />
					<br />
					Email : <input type="text" id="email" class="fadeIn third" style="width: 200px;" name="email"  value="<? echo $user->getEmail() ?>" placeholder="email" disabled />
					<br /><br />
					<div class="flexrow">
						<form method="POST" action="delete.php">  
							<input type="hidden" name='user_id' value='<? echo $user->getId() ?>' >
							<input type="submit" class="fadeIn fourth" value="delete" style="width: 100px" >
						</form>
						<form method="POST" class="flexrow" action="compte.php">
							<input type="hidden" id='user_id' value='<?php echo $user->getId() ?>' >
							<input type="button" id='modify' onclick="enableInputs()" class="fadeIn fourth" value="modify" style="width: 100px" >
							<input type="button" id='validate' onclick="validateInputs()" class="fadeIn fourth" value="validate" style="width: 100px; display: none;" >
							<input type="button" id='historique' class="fadeIn fourth" value="Historique" onclick="display_historique()" style="width: 100px;" >
						</form>
					</div>

			<?php } ?>
		</div>
	</div>
	<?php if($user->isAdmin()):?>		
	
		<div class="wrapper">
			<table id="users">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>Email</th>
						<th>ECTS</th>
						<th>Admin</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$usersList = $userRepository->getAllUsersListActivated();
						foreach ($usersList as $key => $user) {
							$id = $user->getId();
							$login = $user->getLogin();
							$email = $user->getEmail();
							$ects = $user->getEcts();
							$isAdmin = $user->isAdmin()==1?'Oui':'Non';
							echo "<tr><td>$id</td><td>$login</td><td>$email</td><td>$ects</td><td>$isAdmin</td><td><a href=\"compte/delete/$id\">Supprimer</a></td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</div>

