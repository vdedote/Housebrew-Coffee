<?php
	include("connection.php");
	mysql_select_db($dbName);

$sql = "CREATE TABLE users(
		userID int AUTO_INCREMENT ,
		username varchar(20),
		password varchar(20),

		PRIMARY KEY (userID)
		);";
	$result = mysql_query($sql);
	if(!$result)
		echo " Error creating table: ". mysql_error();
	else
		echo " Table created!";
	mysql_close($con);
?>