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
// Include config file
require_once "config.php";

$username = $_SESSION["username"];
$mime = "image/jpeg";
$title = $caption = $imagetmp = $catagory = "";
$title_err = $caption_err = $file_err = "";
$newfilename = "";
$isuploaded = "false";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if title is empty
    if(empty(trim($_POST["title"]))){
        $title_err = "This field couldn't be empty.";
    } else{
        $title = $_POST["title"];
    }
    // Check if catagory is empty
    if(!empty(trim($_POST["catagory"]))){
        $catagory =  $_POST["catagory"];;
    }
	
	
    // Check if caption is empty
    if(!empty(trim($_POST["caption"]))){
        $caption =  $_POST["caption"];;
    }
	// Check terget image
    if(empty(trim($_POST['img_url'])) && ($_FILES["myimage"]['size'] == 0)) {
		$file_err = "please select a file or give a valid url.";
		echo "not selected!";
	} else if ($_FILES["myimage"]['size'] > 0) {
		if (!($_FILES['myimage']['type'] == 'image/jpeg' || $_FILES['myimage']['type'] == 'image/png' || $_FILES['myimage']['type'] == 'image/gif')){
			$file_err="invalid file type!";
		} else {
			$mime = $_FILES['myimage']['type'];
			$temp = explode(".", $_FILES["myimage"]["name"]);
			$newfilename = round(microtime(true));
			if (move_uploaded_file($_FILES["myimage"]["tmp_name"], 'img/uploads/'.$newfilename . '.' . end($temp))) {
				$isuploaded = "true";
			}
		}
	} else if (!empty(trim($_POST['img_url']))) {
		$url = $_POST['img_url'];
		$imagetmp = file_get_contents($url);
		//echo "url detected!";
		$temp = explode(".", $url);
		$newfilename = round(microtime(true));
		$new = 'img/uploads/'.$newfilename. '.' . end($temp);;
		if (file_put_contents($new, $imagetmp)){
			$isuploaded = "true";
		}
	}
    //Validate credentials
	if(empty($title_err) && empty($caption_err) && empty($file_err) && $isuploaded  == "true"){
        // Prepare a select statement
        $sql = "INSERT INTO uploads (image_id, username, image_title, image_caption, mime, catagory) VALUES (?, ?, ?, ?, ?, ?)";
        //echo "sql created!"; 
        if($stmt = $mysqli->prepare($sql)){
			echo "sql prepared!";
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss",$newfilename,$username,$title,$caption,$mime,$catagory);
			if($stmt->execute()){
				// Redirect to verify page
                header("location: conformation.php?cf=upload");
            } else{
                echo "Something went wrong. Please try again later.";
            }
			// Close statement
			$stmt->close();
        } else {
		 echo "sql not prepared!";
		}
		         
    }
    
    // Close connection
    $mysqli->close();
}
?>

<div class="wrapper">	
	<div class="wrapper-title"><h2>Upload your photo</h2></div>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
		<div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
			<label>Title</label>
			<input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
			<label>Catagory</label>
				<select name="catagory" class="form-control">
					<option value="nature">Nature</option>
					<option value="relegious">Relegious</option>
					<option value="scientific">Scientific</option>
					<option value="lifestyle">Lifestyle</option>
				</select>
		</div> 
		<div class="form-group <?php echo (!empty($caption_err)) ? 'has-error' : ''; ?>">
			<label>Caption</label>
			<textarea  name="caption" class="form-control" value="<?php echo $caption; ?>" placeholder="About this photo"></textarea>
			<span class="help-block"><?php echo $caption_err; ?></span>
		</div>
		<div>
			<h4>upload via<h4>
			<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#device">device</a></li>
			<li><a data-toggle="tab" href="#url">URL</a></li>
			</ul>

			<div class="tab-content">
				<div id="device" class="tab-pane fade in active">
					<div class="form-group" >
						<br /><input type="file" name="myimage" class="form-control" onchange="preview_image(event)">
										<span class="help-block"><?php echo $file_err; ?></span>
						<br /><img id="output_image" src="./img/preview.png" style="max-width:300px"/>
					</div>
				</div>
				<div id="url" class="tab-pane fade">
					<div class="form-group" >
						<br /><input type="text" name="img_url" placeholder="Enter Image URL" class="form-control">
										<span class="help-block"><?php echo $file_err; ?></span>
						<br /><img src="./img/preview.png" class="preview" style="max-width:300px"/>
						
					</div>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Upload">
			</div>
		</div>	
	</form>
</div

<?php include "./footer.php"; ?>