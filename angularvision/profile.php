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
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
	echo "<div class='photo_container'>";
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
		echo "<div class='item item".$ph."'>";
		echo "<a href='./photo.php?id=".$row["image_id"]."'>";
        echo "<img src='./img/uploads/" . $row["image_id"].".".$mime."' ></a></div>";
    }
	echo "</div>";
} else {
    echo "0 results";
}
$mysqli->close();

?>

<div class="bundle-content-container">
    <div class="bundle-content"> 
        <a href="./brand.php?id=10">
            <div class="bundle-icon"><i class="fas fa-cog"></i></div>
            <div class=bundle-text><span>All Catagories</span></div>
        </a>
    </div> 
    <div class="bundle-content"> 
        <a href="./brand.php?id=20">
            <div class="bundle-icon"><i class="fas fa-leaf"></i></div>
            <div class=bundle-text><span>Natural</span></div>
        </a>
    </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=30">
            <div class="bundle-icon"><i class="fas fa-kaaba"></i></div>
            <div class=bundle-text style="padding-top: 28px;"><span>Religious</span></div>
        </a>
   </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=40">
            <div class="bundle-icon"><i class="fas fa-brain"></i></div>
            <div class=bundle-text style="padding-top: 32px;"><span>Scientific</span></div>
        </a>
    </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=50">
            <div class="bundle-icon"><i class="fab fa-linux"></i></div>
            <div class=bundle-text><span>Life Style</span></div>
        </a>
   </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=60">
            <div class="bundle-icon"><i class="fas fa-camera"></i></div>
            <div class=bundle-text><span>Others</span></div>
        </a>
   </div>
    
</div>

<?php include "./footer.php"; ?>