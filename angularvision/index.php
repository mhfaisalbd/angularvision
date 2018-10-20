<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		include "./header-public.php";
	}
    else {
		include "./header.php";
	}
?>

<?php include "./footer.php"; ?>