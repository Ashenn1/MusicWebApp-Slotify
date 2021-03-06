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
		newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0] , newPlaylist , false); 
		updateVolumeProgressBar(audioElement.audio);


		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove" , function(e){
			e.preventDefault();
		});


		$(".playbackBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e){
			if(mouseDown == true)
			{
				//Set time of song depending on position of the mouse.
				//"this" refers to the object that called the event i.e $(".playbackBar .progressBar"). 
				timeFromOffset(e,this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e){
			timeFromOffset(e,this);
		});

		$(".volumeBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e){
			if(mouseDown == true)
			{
				var percentage = e.offsetX / $(this).width();
				if(percentage >= 0 && percentage <= 1)
					audioElement.audio.volume = percentage;
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e){
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <= 1)
				{audioElement.audio.volume = percentage;}
		});

		$(document).mouseup(function(){
			mouseDown = false;
		});

	});

	function timeFromOffset(mouse , progressBar){

		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
	}

	function previousSong(){

		if(audioElement.audio.currentTime >= 3 || currentIndex==0){
			audioElement.setTime(0);
		}
		else{
			currentIndex--;
			setTrack(currentPlaylist[currentIndex] , currentPlaylist , true);
		}
	}

	function nextSong(){

		if(repeat == true)
		{
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length-1){
			currentIndex=0;
		}
		else{
			currentIndex++;
		}
		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay , currentPlaylist , true);
	}

	function setRepeat(){
		repeat = !repeat;
		var imageName = repeat ? "repeat-active.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src" , "Assets/Images/icons/" + imageName);
	}

	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		$(".controlButton.volume img").attr("src" , "Assets/Images/icons/" + imageName);
	}

	function setShuffle(){
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src" , "Assets/Images/icons/" + imageName);

		if(shuffle){
			//Randomize playlist
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else{
			//Shuffle has been deactivated
			//Go back to regular playlist
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function shuffleArray(playlist){
		var randNum, tmp, i;

		//Just swapping values around.
		for(i=playlist.length; i; i--){
			randNum = Math.floor(Math.random()*i);
			tmp = playlist[i-1];
			playlist[i-1] = playlist[randNum];
			playlist[randNum] = tmp;
		}
	}


	function setTrack(trackId , newPlaylist , play){

		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice(); // slice() to copy of the array not a reference.
			shuffleArray(shufflePlaylist);
		}

		if(shuffle)
			currentIndex = shufflePlaylist.indexOf(trackId);
		else
			currentIndex = currentPlaylist.indexOf(trackId);

		$.post("Includes/Handlers/ajax/getSongJson.php" , {songId : trackId} , function(data){

			var track = JSON.parse(data);

			$(".trackName span").text(track.title);

			$.post("Includes/Handlers/ajax/getArtistJson.php" , {ArtistId : track.artist} , function(data){
				var artist = JSON.parse(data);
				console.log(artist);
				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick" , "openPage('artist.php?id=" + artist.id + "')");
			});

			$.post("Includes/Handlers/ajax/getAlbumJson.php" , {AlbumId : track.album} , function(data){
				var album = JSON.parse(data);
				console.log(album); 
				$(".content .albumLink img").attr("src", album.artworkPath);
				$(".content .albumLink img").attr("onclick" , "openPage('album.php?id=" + album.id + "')");
				$(".trackInfo .trackName span").attr("onclick" , "openPage('album.php?id=" + album.id + "')");
			});

			console.log(track);
			audioElement.setTrack(track);
			//playSong();

			if(play){
				playSong();	 
			}
		});

		
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
								<img role="link" tabindex="0" src="" class="albumArtwork">
							</span>	

							<div class="trackInfo">

								<span class="trackName">
									<span role="link" tabindex="0"></span>
								</span>

								<span class="artistName">
									<span role="link" tabindex="0"></span>
								</span>

							</div>

						</div>
					</div>

					<div id="nowPlayingCenter">
						<div class="content playerControls">

							<div class="buttons"> 
								<button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
									<img src="Assets/Images/icons/shuffle.png" alt="Shuffle">
								</button>

								<button class="controlButton previous" title="Previous Button" onclick="previousSong()">
									<img src="Assets/Images/icons/previous.png" alt="Previous">
								</button>

								<button class="controlButton play" title="Play Button" onclick="playSong()">
									<img src="Assets/Images/icons/play.png" alt="Play">
								</button>
		 
								<button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
									<img src="Assets/Images/icons/pause.png" alt="Pause">
								</button>

								<button class="controlButton next" title="Next Button" onclick="nextSong()">
									<img src="Assets/Images/icons/next.png" alt="Next">
								</button>

								<button class="controlButton repeat" title="Repeat Button" onclick="setRepeat()">
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
								<img src="Assets/Images/icons/volume.png" alt="Volume" onclick="setMute()">
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