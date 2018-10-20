<?php include "./header-public.php"; ?>
<?php
// Include config file
require_once "config.php";

$auth = $email = "";
$verify_err = "";
//
if (!empty($_GET['auth']) && !empty($_GET['email']) ){
	$auth = $_GET['auth'];
	$email = $_GET['email'];
	//echo "<script> var auth = ".$auth."; var email = ".$email.";</script>";
	//echo "auth =".$auth."<br />email =".$email."<br />";
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//
	$auth = $_POST["auth"];
	$email = $_POST["email"];
    // Check if verification code is empty
    if(empty(trim($_POST["value1"].$_POST["value2"].$_POST["value3"].$_POST["value4"].$_POST["value5"]))){
        $verify_err = "Please enter verification code.";
    } else{
        $value = trim($_POST["value1"].$_POST["value2"].$_POST["value3"].$_POST["value4"].$_POST["value5"]);
		$value = md5($value);
	}
    if(($value !== $auth)){
		$verify_err = "Invalid verification code!";		
	}
    // Validate credentials
    if(empty($verify_err)){
        // Prepare a select statement
        $sql = "update users set verified = 'YES' WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                //
				echo '<script language="javascript">';
				echo 'alert("Thanks! Your Email is varified.")';
				echo '</script>';
				// Redirect user to welcome page
				header("location: conformation.php?cf=email");
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}

?>
	<?php 
		echo "<h4 style='text-align:center'>An Email with verification code was sent to your Email address. Please check and verify your Email address.<h4>";
	?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($verify_err)) ? 'has-error' : ''; ?>" style="width:100%;text-align:center;float:left">
                <div><label>Varification Code</label><div>
                <div style="display:inline-block">
					<input style="float:left;width:auto" type="text" size = "1" name="value1" class="form-control" >
					<input style="float:left;width:auto" type="text" size = "1" name="value2" class="form-control" >
					<input style="float:left;width:auto" type="text" size = "1" name="value3" class="form-control" >
					<input style="float:left;width:auto" type="text" size = "1" name="value4" class="form-control" >
					<input style="float:left;width:auto" type="text" size = "1" name="value5" class="form-control" >
					<span class="help-block"><?php echo $verify_err; ?></span>

				</div>
				<div>
					<input type="hidden" name="auth" value="<?php echo $auth;?>" />
					<input type="hidden" name="email" value="<?php echo $email;?>" />
				</div>
			</div>
			<div class="form-group" style="width:100%;text-align:center;float:left">
				<input type="submit" class="btn btn-primary" value="Submit">
				<input type="reset" class="btn btn-default" value="Reset">
			</div>
<?php include "./footer.php"; ?>