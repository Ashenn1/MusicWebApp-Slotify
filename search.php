<?php
	
	include("Includes/includedFiles.php");

	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);
	}
	else{
		$term = "";
	}

?>

<div class="searchContainer">
	<h4>Search for an artist, album or song</h4>
	<input type="text" class="searchInput" value="<?php echo $term ;?>" placeholder="Start Typing..." onfocus="var val=this.value; this.value=''; this.value= val;" />
</div>

<script>

	$(".searchInput").focus();
	
	$(function(){

		var timer;

		//This code will wait 2 seconds after typing is finished and will execute.
		$(".searchInput").keyup(function(){
			clearTimeout(timer);

			timer = setTimeout(function(){
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
			} , 2000);
		});
	});


	$("input.focus").focus(function () {
	    var val = this.value,
	        $this = $(this);
	    $this.val("");
    });
</script>


<div class="trackListContainer borderBottom">
 		<h2>SONGS</h2>
 		<ul class="trackList">
 			<?php

 				$songsQuery = mysqli_query($con ,  "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

 				if(mysqli_num_rows($songsQuery) == 0){
 					echo "<span class='noResults'>No songs found matching " . $term . "</span>";
 				}

 				$songIdArray = array();	
 				$rowCnt = 1;
 				while ($row = mysqli_fetch_array($songsQuery)) {

 					if($rowCnt > 10) break;

 					array_push($songIdArray , $row['id']);
 					 
 					$albumSong = new Song($con , $row['id']);
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


 <div class="artistsContainer borderBottom">

 	<h2>Artists</h2>

 	<?php

 		$artistsQuery = mysqli_query($con , "SELECT id FROM artist WHERE name LIKE '$term%' LIMIT 10");

 		if(mysqli_num_rows($artistsQuery) == 0){
 					echo "<span class='noResults'>No artists found matching " . $term . "</span>";
 				}
 		while($row = mysqli_fetch_array($artistsQuery)){

 			$artistFound = new Artist($con , $row['id']);

 			echo "<div class='searchResultRow'> 
 					<div class='artistName'>
 						<span role = 'link' tabindex='0' onclick='openPage(\"artist.php?id=".$row['id'] ."\")'> 

 							". $artistFound->getName(). "

 						 </span>
 					</div>
 			</div>"	;
 		}

 	?>
 	
 </div>