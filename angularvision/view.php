<?php
$dbh = new PDO("mysql:host=localhost;dbname=angularvision","root","");
$id = isset($_GET['id'])? $_GET['id'] : "";
$stat = $dbh->prepare("select * from uploads where image_id=?");
$stat->bindParam(1,$id);
$stat->execute();
$row = $stat->fetch();
header("Content-Type:".$row['mime']);
echo $row['image'];
//echo '<img src="data:image/jpeg;base64,'.base64_encode($row['data']).'"/>';
?>