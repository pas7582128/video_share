<?php
include ('connection.php');



$id=$_GET['id'];

$update=mysqli_query($con,"UPDATE users SET status='1' WHERE id='$id'");
if($update){
	echo "<script> window.location.href='view_users.php' </script>";
}else{
	echo "<script> alert('Sorry Something Went Wrong...') </script>";
	echo "<script> window.location.href='view_users.php' </script>";
}
?>