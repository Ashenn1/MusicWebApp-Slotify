<?php
	
	//db connection variable.
	include("../../config.php");

	if(isset($_POST['playlistId'])){

		$playlistId = $_POST['playlistId'];

		$playlistQuery = mysqli_query($con , "DELETE FROM playlist WHERE id = '$playlistId'");
		$SongsQuery = mysqli_query($con , "DELETE FROM playlistsongs WHERE playlistId = '$playlistId'");

	}
	else{
		"PlaylistId wasn't passed into deletePlaylist.php";
	}
?>