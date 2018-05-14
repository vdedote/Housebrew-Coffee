<?php
	include("connection.php");
	mysqli_select_db($dbName);

$sql = "CREATE TABLE posts(
		id int AUTO_INCREMENT,
		image varchar(255),
		title varchar(255),
		content varchar(255),
		timedate datetime,

		PRIMARY KEY (id)
		);";
	$result = mysqli_query($sql);
	if(!$result)
		echo " Error creating table: ". $con->error();
	else
		echo " Table created!";
	// mysqli->close($con);
	$con->close();
?>
