<?php 
	include("Includes/includedFiles.php");

	if(isset($_GET['id'])){
		$playlistId = $_GET['id'];
	}
	else{
		header("Location: index.php ");
	}

	$playlist = new Playlist($con , $playlistId);
	$owner = new User($con , $playlist->getOwner());

 ?>

 <div class="entityInfo">
 	 
 	<div class="leftSection">
 		<div class="playlistImage">
 			<img src="Assets/Images/icons/playlist.png">
 		</div>
 		
 	</div>

 	<div class="rightSection">

 		<h2> <?php echo $playlist->getName(); ?> </h2>
 		<p>By <?php echo $playlist->getOwner(); ?> </p>
 		<p> <?php echo $playlist->getNumberOfSongs(); ?> songs </p>
 		<button class="button" onclick="deletePlaylist('<?php echo $playlistId ?>')">DELETE PLAYLIST</button>

 	</div>

 </div>

 <div class="trackListContainer">
 		
 		<ul class="trackList">
 			<?php
 				$songIdArray = $playlist->getSongIds();	
 				$rowCnt = 1;
 				foreach ($songIdArray as $songId) {
 					 
 					$playlistSong = new Song($con , $songId);
 					$songAritst = $playlistSong->getArtist();

 					echo "<li class='trackListRow'> 

 							<div class='trackCount'>
 								<img class='pay' src='Assets/Images/icons/play-white.png' onclick='setTrack(\"".$playlistSong->getId()."\" , tmpPlaylist , true)'>
 								<span class='trackNumber'> $rowCnt </span>
 							</div>

 							<div class='trackInfo'>
 								<span class='trackName'>". $playlistSong->getTitle()."</span>
 								<span class='artistName'>". $songAritst->getName()."</span>
 							</div>

 							<div class='trackOptions'>
 								<input type='hidden' class='songId' value='".$playlistSong->getId()."'>
 								<img class='optionsBtn' src='Assets/Images/icons/more.png' onclick='showOptionsMenu(this)'>
 							</div>

 							<div class='trackDuration'>
 								<span class='duration'>".$playlistSong->getDuration()."</span>
 							</div>

 						  </li>";

 					$rowCnt++;
 				}
 			?>

 			<script>
 				var tmpSongIds = '<?php echo json_encode($songIdArray); ?>';
 				tmpPlaylist = JSON.parse(tmpSongIds);
 			</script>

 		</ul>

 </div>

  <nav class="optionsMenu"> 
 	<input type="hidden" class="songId">
 	<?php echo Playlist::getPlaylistDropdown($con , $userLoggedIn->getusername()); ?>

 </nav>
		