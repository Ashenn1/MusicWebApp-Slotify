<?php 
	include("Includes/header.php");

	if(isset($_GET['id'])){
		$albumId = $_GET['id'];
	}
	else{
		header("Location: index.php ");
	}

	$album = new Album($con , $albumId); 
 	
 	$artist = $album->getArtist();

 ?>

 <div class="entityInfo">
 	 
 	<div class="leftSection">
 		<img src="<?php echo $album->getArtworkPath(); ?>">
 	</div>

 	<div class="rightSection">

 		<h2> <?php echo $album->getTitle(); ?> </h2>
 		<p> <?php echo $artist->getName(); ?> </p>
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
 								<img class='pay' src='Assets/Images/icons/play-white.png'>
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
 		</ul>

 </div>


<?php include("Includes/footer.php"); ?>		