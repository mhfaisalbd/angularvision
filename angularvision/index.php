<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		include "./header-public.php";
		echo("
		<div class='cta-content'>
			<h2>Stop waiting &<br>Start Caturing.</h2>
			<img src='./img/cam.png'>
			<a href='./login.php' class='btn btn-outline btn-xl js-scroll-trigger'>Let's Get Started!</a>	
		</div>
		");
	}
    else {
		include "./header.php";
		echo("
		<div class='cta-content'>
			<h2>Stop waiting &<br>Start Caturing.</h2>
			<img src='./img/cam.png'>
			<a href='./upload.php' class='btn btn-outline btn-xl js-scroll-trigger'>Let's Get Started!</a>
    	</div>
		");
	}
?>

<?php include "./footer.php"; ?>