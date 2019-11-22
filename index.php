
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

	<div id="mainContainer">

		<div id="topContainer">
			
			<div id="navBarContainer">
				<nav class="navBar">
					<a href="index.php" class="logo">
						<img src="Assets/Images/icons/doglogo.png">
					</a>
				</nav>
			</div>

		</div>
		
		<div id="nowPlayingBarContainer">
				<div id="nowPlayingBar">
					<div id="nowPlayingLeft">
						<div class="content">
							<span class="albumLink">
								<img src="http://clipart-library.com/img/2008830.jpg" class="albumArtwork">
							</span>	

							<div class="trackInfo">

								<span class="trackName">
									<span>Happy Birthday</span>
								</span>

								<span class="artistName">
									<span>Soha Ahmed</span>
								</span>

							</div>

						</div>
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

							<div class="playbackBar">
								
								<span class="progressTime current">0.00</span>
								<div class="progressBar">
									<div class="progressBarBackground">
										<div class="progress"></div>
									</div>
								</div>
								<span class="progressTime remaining">0.00</span>

							</div>


						</div>
						
					</div>

					<div id="nowPlayingRight">
						
						<div class="volumeBar">
							<button class="controlButton volume" title="Volume Button">
								<img src="Assets/Images/icons/volume.png" alt="Volume">
							</button>

							<div class="progressBar">
									<div class="progressBarBackground">
										<div class="progress"></div>
									</div>
								</div>
								
						</div>

					</div>
			</div>
		</div>

	</div>


</body>
</html>