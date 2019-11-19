
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
		<div id="nowPlayingBar">
			<div id="nowPlayingLeft">
				
			</div>

			<div id="nowPlayingCenter">
				<div class="content playerControls">

					<div class="buttons"> 
						<button class="controlButton shuffle" title="Shuffle Button">
							<img src="Assets/Images/icons/shuffle.png" alt="Shuffle">
						</button>

						<button class="controlButton previous" title="Previous Button">
							<img src="Assets/Images/icons/previous.png" alt="Previous">
						</button>

						<button class="controlButton play" title="Play Button">
							<img src="Assets/Images/icons/play.png" alt="Play">
						</button>
 
						<button class="controlButton pause" title="Pause Button" style="display: none;">
							<img src="Assets/Images/icons/pause.png" alt="Pause">
						</button>

						<button class="controlButton next" title="Next Button">
							<img src="Assets/Images/icons/next.png" alt="Next">
						</button>

						<button class="controlButton repeat" title="Repeat Button">
							<img src="Assets/Images/icons/repeat.png" alt="Repeat">
						</button>

					</div>
				</div>
				
			</div>

			<div id="nowPlayingRight">
				
			</div>
		</div>
	</div>


</body>
</html>