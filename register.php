<?php
	
	include("Includes/config.php");
	include("Includes/Classes/Account.php");
	include("Includes/Classes/Constants.php");
	$account = new Account($con);
	include("Includes/Handlers/register-handler.php");
	include("Includes/Handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="Assets/js/register.js"> </script>

	<title>Welcome to Slotify!</title>
</head>
<body>
	<?php

		if(isset($_POST['registerBtn'])){
			echo '<script>

				$(document).ready(function(){
					$("#loginForm").hide();
					$("#registerForm").show();
				});	

				</script>
			';
		}
		else{
			echo '<script>

				$(document).ready(function(){
					$("#loginForm").show();
					$("#registerForm").hide();
				});	

			</script>
		';
		}

	?>
 
	
	<div id = "background">
		
		<div id="loginContainer">

			<div id = "inputContainer">
				<form id = "loginForm" action="register.php" method = "POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed) ; ?>
						<label for="loginUsername" >Username</label>
						<input id = "loginUsername" type="text" name="loginUsername" value="<?php getInputValue('loginUsername') ?>" placeholder = "eg. Robin9x" required>	
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id = "loginPassword" type="password" name="loginPassword" value="<?php getInputValue('loginPassword') ?>" placeholder = "Password" required> 	
					</p>
				
					<button type="submit" name="loginbtn">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Sign up here.</span>
					</div>
					
				</form>

				<form id = "registerForm" action="register.php" method = "POST">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters) ; ?>
						<?php echo $account->getError(Constants::$usernameTaken) ; ?>
						<label for="username" >Username</label>
						<input id = "username" type="text" name="username" value="<?php getInputValue('username') ?>" placeholder = "Username" required>	
					</p> 
					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters) ; ?>
						<label for="firstName" >First Name</label>
						<input id = "firstName" type="text" name="firstName" value="<?php getInputValue('firstName') ?>"placeholder = "eg. Robin" required>	
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters) ; ?>
						<label for="lastName" >Last Name</label>
						<input id = "lastName" type="text" name="lastName" value="<?php getInputValue('lastName') ?>"placeholder = "eg. Heath" required>	
					</p>
					<p>
						<?php echo $account->getError(Constants::$emailsDontMatch) ; ?>
						<?php echo $account->getError(Constants::$invalidEmail) ; ?>
						<?php echo $account->getError(Constants::$emailTaken) ; ?>
						<label for="email" >Email</label>
						<input id = "email" type="email" name="email" value="<?php getInputValue('email') ?>" placeholder = "eg. Robinxy@gmail.com" required>	
					</p>
					<p>
						<label for="email2" >Confirm Email</label>
						<input id = "email2" type="email" name="email2" value="<?php getInputValue('email2') ?>" placeholder = "Confirm Email" required>	
					</p>
					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch) ; ?>
						<?php echo $account->getError(Constants::$passwordsNotAlphanumeric) ; ?>
						<?php echo $account->getError(Constants::$passwordCharacters) ; ?>
						<label for="password">Password</label>
						<input id = "password" type="password" name="password" value="<?php getInputValue('password') ?>" placeholder = "Password" required> 	
					</p>

					<p>
						<label for="password2">Confirm Password</label>
						<input id = "password2" type="password" name="password2" value="<?php getInputValue('password2') ?>" placeholder = "Confirm Password" required> 	
					</p>

					<button type="submit" name="registerBtn">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Alread have an account? Login here.</span>
					</div>
					
				</form>

			</div>

			<div id="loginText">
				<h1>Great music made just for you, right here.</h1>
				<h2>Best music, best quality & all for free.</h2>
				<ul>
					<li>Discover new music easily everyday</li>
					<li>Create your own playlists</li>
					<li>follow your favorite artists to keep up to date</li>
				</ul>
			</div>
				
		</div>
	</div>
</body>
</html>