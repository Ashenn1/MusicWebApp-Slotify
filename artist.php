<?php
	
	include("Includes/includedFiles.php");

	if(isset($_GET['id'])){
		$artistId = $_GET['id'];
	}
	else{
		header("Location: index.php ");
	}


	$artist = new Artist($con , $artistId);

?>

<div class="entityInfo borderBottom">
	
	<div class="centerSection">
		
		<div class="artistInfo">
			
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="headerButtons">
				<button class="button green">PLAY</button>
			</div>

		</div>

	</div>

</div>


<div class="trackListContainer borderBottom">
 		
 		<ul class="trackList">
 			<?php
 				$songIdArray = $artist->getSongIds();	
 				$rowCnt = 1;
 				foreach ($songIdArray as $songId) {

 					if($rowCnt > 5) break;
 					 
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