<html>
<head>
<link href="./style.css" rel='stylesheet' type='text/css' />
</head>
<body>
	<?php
		session_start();
		include 'config.php';
		$sql="SELECT image_id, image FROM `uploads` where username=".$_SESSION["username"];
		

if ($stmt = $mysqli->prepare($sql)) {

    /* execute statement */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($col1, $col2);
	echo $col2;
    /* fetch values */
    while ($stmt->fetch()) {
       
		header("Content-Type: image/jpeg");
		echo '<img src="data:image/jpeg;base64,'.base64_encode($col2).'"/>';
    }

    /* close statement */
    $stmt->close();
} else {
	echo "0000000";
}

/* close connection */
$mysqli->close();
?>
</body>
</html>