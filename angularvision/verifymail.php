<?php
	// Include config file
	require_once "config.php";

	$x = 4; // Amount of digits
	$min = pow(10,$x);
	$max = pow(10,$x+1)-1;
	$value = rand($min, $max);
	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );
	$from = "bdmhfaisal@gmail.com";
	$to = $_GET['email'];
	$subject = "AngularVision : Verify your account";
	$message = "Your verification code is: ".$value;
	$headers = "From:" . $from;
	mail($to,$subject,$message, $headers);
	//echo "The email message was sent.";
	//mysqli_query();
	$value = "$value";
	$auth = md5($value);
	// Redirect to verify page
    header("location: verify.php?auth=".$auth."&email=".$to);
?>