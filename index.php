
<?php
	include("Includes/config.php");
	if(isset($_SESSION["userLoggedIn"]))
	{
		$userLoggedIn = $_SESSION["userLoggedIn"];
	}
	else
		header("Location: register.php");
?>
 
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Slotify</title>
	<link rel="stylesheet" type="text/css" href="Assets/css/style.css">
</head>
<body>

	<div id="nowPlayingBarContainer">
		
	</div>


</body>
</html>