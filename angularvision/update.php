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
        if($_SESSION["username"] !== $uploader){
            header("location: photo.php?id=".$id."");
        }
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
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["title"])  && isset($_POST["caption"]) && isset($_POST["catagory"]) && isset($_POST["id"])){
        $title = $_POST["title"];
        $caption = $_POST["caption"];
        $catagory = $_POST["catagory"];
        $id = $_POST["id"];
    }
    $sql = "UPDATE `uploads` SET `image_title` = ?, `image_caption` = ?, `catagory` = ? WHERE `uploads`.`image_id` = ?";
        //echo "sql created!"; 
        if($stmt = $mysqli->prepare($sql)){
			echo "sql prepared!";
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss",$title,$caption,$catagory,$id);
			if($stmt->execute()){
				// Redirect to verify page
                header("location: conformation.php?cf=edit");
            } else{
                echo "Something went wrong. Please try again later.";
            }
			// Close statement
			$stmt->close();
        } else {
		 echo "sql not prepared!";
		}
}
?>
<div class="wrapper">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
		<div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
			<label>Title</label>
			<input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
			<label>Catagory</label>
				<select name="catagory" class="form-control">
					<option value="nature" <?php echo ($catagory === "nature") ? 'selected' : ''; ?>>Nature</option>
					<option value="relegious" <?php echo ($catagory === "relegious") ? 'selected' : ''; ?>>Relegious</option>
					<option value="scientific" <?php echo ($catagory === "scientific") ? 'selected' : ''; ?>>Scientific</option>
					<option value="lifestyle" <?php echo ($catagory === "lifestyle") ? 'selected' : ''; ?>>Lifestyle</option>
				</select>
		</div> 
		<div class="form-group">
			<label>Caption</label>
			<textarea  name="caption" class="form-control"><?php echo $caption; ?></textarea>
		</div>
        <div class="form-group">
            <input type="text" name="id" value="<?php echo $id ?>" hidden>
            <input type="submit" class="btn btn-primary" value="Update">
        </div>
    </form>
    </div>