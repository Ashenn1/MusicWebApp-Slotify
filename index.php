
<?php
	include("Includes/config.php");
	if(isset($_SESSION["userLoggedIn"]))
	{
		$userLoggedIn = $_SESSION["userLoggedIn"];
	}
	else
		header("Location: register.php");
?>
 
<!DOCTYPE html>
<html>
<head>
	<title>Hello to index page</title>
</head>
<body>
<h2>Hellooo!</h2>
</body>
</html>