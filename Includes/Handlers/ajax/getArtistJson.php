<?php
	
	//To get DB connection vars
	include("../../config.php");

	if(isset($_POST['ArtistId'])){
		$ArtistId = $_POST['ArtistId'];
		$query = mysqli_query($con , " SELECT * FROM artist WHERE id='$ArtistId' ");
		$resultArray = mysqli_fetch_array($query);

		echo json_encode($resultArray);
	}

	
?>