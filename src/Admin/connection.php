<?php
	//connection variables
		//hostname
	$dbHost= "localhost";
	//username
	$dbUser = "root";
	//password
	$dbPass = "";
//database name
	$dbName = "housebrew";

	//save connection in variable for checking
	$con = mysqli_connect($dbHost, $dbUser, $dbPass);
	//connection checking
	if (!$con) die("Connection Error: ". mysql.error());
	//Display message for checking
	// echo("Connected Successfully!");

?>
