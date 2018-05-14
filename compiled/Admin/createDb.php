<?php
	//Call connection handle
	include_once("connection.php");
	if(!mysqli_select_db($dbName))
	{
		$sql = "CREATE DATABASE IF NOT EXISTS " . $dbName;
		if (mysql_query($sql))
			echo"<br>Database $dbName created!";
		else
			echo "Error creating database:".mysql_error();

	}
	else {
		echo" <br> Database already exists!";
		mysql_select_db($dbName);
	}
	mysql_close($con);
?>
