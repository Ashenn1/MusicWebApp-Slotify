<?php 
	include("Includes/header.php");

	if(isset($_GET['id'])){
		$albumId = $_GET['id'];
	}
	else{
		header("Location: index.php ");
	}

	$albumQuery = mysqli_query($con , "SELECT * FROM album WHERE id = '$albumId'");

	$album = mysqli_fetch_array($albumQuery);
	$artistId = $album['artist'];
 
	$artist = new Artist($con , $artistId);

	echo $artist->getName();

 ?>


<?php include("Includes/footer.php"); ?>		