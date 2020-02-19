<?php 
	include("Includes/includedFiles.php");

	if(isset($_GET['id'])){
		$albumId = $_GET['id'];
	}
	else{
		header("Location: index.php ");
	}

	$album = new Album($con , $albumId);  	
 	$artist = $album->getArtist();
 	$artistId = $artist->getId();

 ?>

 <div class="entityInfo">
 	 
 	<div class="leftSection">
 		<img src="<?php echo $album->getArtworkPath(); ?>">
 	</div>

 	<div class="rightSection">

 		<h2> <?php echo $album->getTitle(); ?> </h2>
 		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?> </p>
 		<p> <?php echo $album->getNumberOfSongs(); ?> songs </p>

 	</div>

 </div>

 <div class="trackListContainer">
 		
 		<ul class="trackList">
 			<?php
 				$songIdArray = $album->getSongIds();	
 				$rowCnt = 1;
 				foreach ($songIdArray as $songId) {
 					 
 					$albumSong = new Song($con , $songId);
 					$albumAritst = $albumSong->getArtist();

 					echo "<li class='trackListRow'> 

 							<div class='trackCount'>
 								<img class='pay' src='Assets/Images/icons/play-white.png' onclick='setTrack(\"".$albumSong->getId()."\" , tmpPlaylist , true)'>
 								<span class='trackNumber'> $rowCnt </span>
 							</div>

 							<div class='trackInfo'>
 								<span class='trackName'>". $albumSong->getTitle()."</span>
 								<span class='artistName'>". $albumAritst->getName()."</span>
 							</div>

 							<div class='trackOptions'>
 								<img class='optionsBtn' src='Assets/Images/icons/more.png'>
 							</div>

 							<div class='trackDuration'>
 								<span class='duration'>".$albumSong->getDuration()."</span>
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
		