<?php
	
	//To get DB connection vars
	include("../../config.php");

	if(isset($_POST['AlbumId'])){
		$AlbumId = $_POST['AlbumId'];
		$query = mysqli_query($con , " SELECT * FROM album WHERE id='$AlbumId' ");
		$resultArray = mysqli_fetch_array($query);

		echo json_encode($resultArray);
	}

	
?>