<?php
include('connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if(isset($_GET['video_id'])){
	$video_id=$_GET['video_id'];
	$approve=mysqli_query($con, "UPDATE video SET approved=1 WHERE id=$video_id");
	if($approve){
		echo "<script> window.location.href='unapproved_videos.php' </script>";
	}else{
		echo "<script> alert('Sorry Something Went Wrong') </script>";
		echo "<script> window.location.href='unapproved_videos.php' </script>";
	}
}

?>