<?php
include('conn.php');

if(!isset($_SESSION))
session_start();

	$video_id=$_GET['video_id'];
	$select_video=mysqli_query($con,"SELECT video_image,video_path FROM video WHERE id='$video_id'");
	$row_video=mysqli_fetch_assoc($select_video);
	$delete=mysqli_query($con, "DELETE FROM video WHERE id='$video_id'");
	if($delete)
	{
		unlink($row_video['video_path']);
		unlink($row_video['video_image']);
		$delete_rating=mysqli_query($con,"DELETE FROM `ratings` WHERE `videoid`='$video_id'");
		$delete_like=mysqli_query($con,"DELETE FROM `likes` WHERE `videoid`='$video_id'");
		$delete_comment=mysqli_query($con,"DELETE FROM `comments` WHERE `videoid`='$video_id'");
		echo "<script> window.location.href='videos.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='videos.php' </script>";
	}
?>