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

$id = isset($_GET['id'])? $_GET['id'] : "0000";
$sql = "SELECT * FROM `uploads` WHERE image_id = '".$id."'";
$result = $mysqli->query($sql);
$uploader="";
$title="";
$catagory="";
$time="";
$caption="";
$mime = 'jpg';
$ability = "disabled";
echo "<div class='main_photo_container'>";
if ($result->num_rows > 0) {
	
    // output data of each row
    while($row = $result->fetch_assoc()) {
		//echo("Queary Succees!");
		if ($row['mime']=='image/jpeg'){
			$mime = 'jpg';
		} else if ($row['mime']=='image/png'){
			$mime = 'png';
		} else if ($row['mime']=='image/gif'){
			$mime = 'gif';
		}
		$uploader = $row['username'];
		$title =$row['image_title'];
		$catagory = $row['catagory'];
		$time = $row['upload_time'];
		$caption = $row['image_caption'];
		if ($_SESSION["username"] === $uploader){
			$ability = "";
		}
	}
}
echo "<div class='photo_loader'> <img src='./img/uploads/".$id.".".$mime."'> </div>";
echo "<div class='photos_right'>";
echo "<div class='photo_operation'>";
echo "<a href='./img/uploads/".$id.".".$mime."' class='btn btn-success'>Download</a>";
echo "<a href='./update.php?id=".$id."' class='btn btn-warning'".$ability.">Update</a>";
echo "<a href='./delete.php?id=".$id."' class='btn btn-danger'".$ability.">Delete</a> </div>";
echo "<div class='photo_title'><span><b>".$title."</b></span></div>";
echo "<div class='photo_basic'><span>by <b>".$uploader."</b> at ".$time."</span></div>";
echo "<div class='photo_cat'><span>Catagorized as: <b>".$catagory."</b></span></div>";
echo "<div class='photo_caption'><span>".$caption."</span></div></div>";
?>
<?php include "./footer.php"; ?>