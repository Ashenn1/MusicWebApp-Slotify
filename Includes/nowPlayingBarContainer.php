<?php
	
	$songQuery = mysqli_query($con , "SELECT id FROM songs ORDER BY RAND() LIMIT 5");
	$resultArray = Array();

	while($row = mysqli_fetch_array($songQuery)){
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);

?>

<script>

	//Will only execute when the page renders fully.
	$(document).ready(function(){
		currentPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(currentPlaylist[0] , currentPlaylist , false); 
	});

	function setTrack(trackId , newPlaylist , play){

		audioElement.setTrack("Assets/music/Imagine Dragons-Thunder.mp3");
		if(play){
			audioElement.play();	
		}
	
	}

	function playSong(){
		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong(){
		$(".controlButton.pause").hide();
		$(".controlButton.play").show();
		audioElement.pause();
	}

</script>



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

								<button class="controlButton play" title="Play Button" onclick="playSong()">
									<img src="Assets/Images/icons/play.png" alt="Play">
								</button>
		 
								<button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
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