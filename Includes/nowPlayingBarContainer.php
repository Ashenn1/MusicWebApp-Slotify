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

		$.post("Includes/Handlers/ajax/getSongJson.php" , {songId : trackId} , function(data){

			var track = JSON.parse(data);

			$(".trackName span").text(track.title);

			$.post("Includes/Handlers/ajax/getArtistJson.php" , {ArtistId : track.artist} , function(data){
				var artist = JSON.parse(data);
				console.log(artist);
				$(".artistName span").text(artist.name);
			});

			$.post("Includes/Handlers/ajax/getAlbumJson.php" , {AlbumId : track.album} , function(data){
				var album = JSON.parse(data);
				console.log(album); 
				$(".albumLink img").attr("src", album.artworkPath);
			});

			console.log(track);
			audioElement.setTrack(track);
			pauseSong();
		});

		if(play){
			audioElement.play();	 
		}
	
	}

	function playSong(){

		if(audioElement.audio.currentTime == 0){
			$.post("Includes/Handlers/ajax/updatePlays.php" , { songId : audioElement.currentlyPlaying.id });
			console.log(audioElement.currentlyPlaying.id);
		}
		

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
								<img src="" class="albumArtwork">
							</span>	

							<div class="trackInfo">

								<span class="trackName">
									<span></span>
								</span>

								<span class="artistName">
									<span></span>
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