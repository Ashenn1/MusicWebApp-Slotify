
<?php
	include("Includes/config.php");
	include("Includes/classes/Artist.php");
	include("Includes/classes/Album.php");
	include("Includes/classes/Song.php");

	if(isset($_SESSION["userLoggedIn"]))
	{
		$userLoggedIn = $_SESSION["userLoggedIn"];
		echo "<script>userLoggedIn = '$userLoggedIn';</script>'";
	}
	else
		header("Location: register.php");
?>
 
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Slotify</title>
	<link rel="stylesheet" type="text/css" href="Assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="Assets/js/script.js"></script>

</head> 
<body>

	<div id="mainContainer">

		<div id="topContainer">
			
			<?php include("Includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">
				
				<div id="mainContent">