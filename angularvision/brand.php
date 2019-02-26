<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php include "./header.php"; ?>
<?php 
require_once "config.php";

$user = isset($_GET['user'])? $_GET['user'] : $_SESSION["username"];

$sql = "SELECT image_id, mime FROM `uploads` WHERE username = '".$user."' ORDER by upload_time DESC";

if (isset($_GET["id"])){
	$bid = $_GET["id"];
	switch ($bid){
		case 1: $sql = "SELECT image_id, mime FROM `uploads` WHERE 1 ORDER by upload_time DESC";
			break;
		case 2: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'nature' ORDER by upload_time DESC";
			break;
		case 3: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'relegious' ORDER by upload_time DESC";
			break;
		case 4: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'scientific' ORDER by upload_time DESC";
			break;
		case 5: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'lifestyle' ORDER by upload_time DESC";
			break;
		case 6: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = null ORDER by upload_time DESC";
			break;
		case 10: $sql = "SELECT image_id, mime FROM `uploads` WHERE username = '".$user."' ORDER by upload_time DESC";
			break;
		case 20: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'nature' and username = '".$user."' ORDER by upload_time DESC";
			break;
		case 30: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'relegious' and username = '".$user."' ORDER by upload_time DESC";
			break;
		case 40: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'scientific' and username = '".$user."' ORDER by upload_time DESC";
			break;
		case 50: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = 'lifestyle' and username = '".$user."' ORDER by upload_time DESC";
			break;
		case 60: $sql = "SELECT image_id, mime FROM `uploads` WHERE `catagory` = '' and username = '".$user."' ORDER by upload_time DESC";
			break;
		default: $sql = "SELECT image_id, mime FROM `uploads` WHERE 1 ORDER by upload_time DESC";
	}
}

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
	echo "<div class='photo_container-big'>";
	$ph = 1;
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$mime = 'jpg';
		if ($row['mime']=='image/jpeg'){
			$mime = 'jpg';
		} else if ($row['mime']=='image/png'){
			$mime = 'png';
		} else if ($row['mime']=='image/gif'){
			$mime = 'gif';
		}
		echo "<div class='item item item".$ph."'>";
		echo "<a href='./photo.php?id=".$row["image_id"]."'>";
        echo "<img src='./img/uploads/" . $row["image_id"].".".$mime."' ></a></div>";
    }
	echo "</div>";
} else {
    echo "0 results";
}
$mysqli->close();

?>