<?php
	
	include("../../config.php");

	if(isset($_POST['playlistId']) && isset($_POST['songId'])){

		$playlistId = $_POST['playlistId'];
		$songId = $_POST['songId'];

		$query = mysqli_query($con , "DELETE FROM playlistsongs WHERE playlistId = '$playlistId' AND songId='$songId'");

	}
	else{
		"PlaylistId or songId wasn't passed into removeFromPlaylist.php";
	}	

?>