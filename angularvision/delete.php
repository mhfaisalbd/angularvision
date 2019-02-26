<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php 
require_once "config.php";

$id = isset($_GET['id'])? $_GET['id'] : "0000";
$sql = "SELECT `username`, `mime` FROM `uploads` WHERE `image_id` = '".$id."'";
$result = $mysqli->query($sql);
$uploader="";
$mime = 'jpg';
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $uploader = $row["username"];
        if ($_SESSION["username"] !== $uploader){
			header("location: photo.php?id=".$id."");
        }
        if ($row['mime']=='image/jpeg'){
			$mime = 'jpg';
		} else if ($row['mime']=='image/png'){
			$mime = 'png';
		} else if ($row['mime']=='image/gif'){
			$mime = 'gif';
		}
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["id"]) && isset($_POST["submit"]) && $_POST["cfm"] === "yes"){
        $id = $_POST["id"];
        $sql = "DELETE FROM `uploads` WHERE `uploads`.`image_id` = '".$id."'";
        
        if($stmt = $mysqli->prepare($sql)){
            
            if($stmt->execute()){
                if (unlink("./img/uploads/".$id.".".$mime)){
                    header("location: conformation.php?cf=del");
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
            
            $stmt->close();
        } else {
		 echo "sql not prepared!";
		}
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Success Confirmation Popup</title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-confirm {		
		color: #636363;
		width: 325px;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-confirm .modal-header {
		border-bottom: none;   
        position: relative;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -15px;
	}
	.modal-confirm .form-control, .modal-confirm .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-confirm .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}	
	.modal-confirm .modal-footer {
		border: none;
		text-align: center;
		border-radius: 5px;
		font-size: 13px;
	}	
	.modal-confirm .icon-box {
		color: #fff;		
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: red;
		padding: 15px;
		text-align: center;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-confirm .icon-box i {
		font-size: 58px;
		position: relative;
		top: 3px;
	}
	.modal-confirm.modal-dialog {
		margin-top: 80px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		/*background: #82ce34;*/
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
        display: inline-block;
    }
	.modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #6fb32b;
		outline: none;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
</style>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
</head>


<!-- Modal HTML -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="fas fa-question"></i>
				</div>					
			</div>
			<div class="modal-body">
				<p class="text-center">Are you sure about deleting this photo?</p>
			</div>
			<div class="modal-footer">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="id" value="<?php echo $id; ?>"  hidden>
                <input type="text" name="cfm" value="yes"  hidden>
                <input class="btn btn-danger btn-block" style="float: left; width: 100px;" type="submit" name="submit" value="Delete">
                </form>
				<button class="btn btn-success btn-block" style="float: right; width: 100px;" data-dismiss="modal" onclick='{location.href="<?php echo "./photo.php?id=".$id; ?>"}'>Cancel</button>
			</div>
		</div>
	</div>
</div>     
</body>
</html>      