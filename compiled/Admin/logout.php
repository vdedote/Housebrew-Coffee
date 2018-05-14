<?php
	function LogOutUser()
	{
		$ErrorMessage = "";
	//Session start to get current logID
	session_start();
	$currentLogID = $_SESSION["ID"];

	// Unset and destroy the session
	session_unset();
	session_destroy();
	$ErrorMessage = "Log OUT succesfully";
	header("Location:loginpage.php");
	return $ErrorMessage;
	}
?>