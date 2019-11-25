<?php
include('connection.php');
if(!isset($_SESSION))
{
	session_start();
}
if(isset($_GET['user_id'])){
	$user_id=$_GET['user_id'];

	$select_photo=mysqli_query($con,"SELECT passport_photo FROM users WHERE id='$user_id'");
	$row_photo=mysqli_fetch_assoc($select_photo);

	$profile_path=$row_photo['passport_photo'];

	unlink("../".$profile_path);
	

	$select_video=mysqli_query($con,"SELECT video_image,video_path FROM video WHERE author_id='$user_id'");


	while($row_video=mysqli_fetch_assoc($select_video))
	{
	$profile_video_image=$row_video['video_image'];
	$profile_video_path=$row_video['video_path'];
	unlink("../".$profile_video_path);
	unlink("../".$profile_video_image);
	}
	//echo mysqli_error($con);

	$delete=mysqli_query($con, "DELETE FROM users WHERE id='$user_id'");
	if($delete){

		$parentids_from_blog=mysqli_query($con,"SELECT id FROM blog_comments WHERE userid='$user_id'");

		$allids=array();
		while($row_parentids=mysqli_fetch_array($parentids_from_blog))
		{
			$allids[]=$row_parentids['id'];
		}
		$allids2=join("','",$allids);

		$delete_blog_comments=mysqli_query($con,"DELETE FROM blog_comments WHERE id IN ('$allids2') OR parentid IN ('$allids2') OR subparentid IN ('$allids2')");


		$parentids_from_comments=mysqli_query($con,"SELECT id FROM comments WHERE userid='$user_id'");

		$allids=array();
		while($row_parentids=mysqli_fetch_array($parentids_from_comments))
		{
			$allids[]=$row_parentids['id'];
		}
		$allids2=join("','",$allids);

		$delete_comments=mysqli_query($con,"DELETE FROM comments WHERE id IN ('$allids2') OR parentid IN ('$allids2') OR subparentid IN ('$allids2')");

		$delete_follow=mysqli_query($con,"DELETE FROM followers WHERE authorid='$user_id' OR followerid='$user_id'");

		$delete_likes=mysqli_query($con,"DELETE FROM likes WHERE videoid IN (SELECT id FROM video WHERE author_id='$user_id') OR userid='$user_id'");

		$delete_ratings=mysqli_query($con,"DELETE FROM ratings WHERE videoid IN (SELECT id FROM video WHERE author_id='$user_id') OR userid='$user_id'");

		$delete_video=mysqli_query($con,"DELETE FROM video WHERE author_id='$user_id'");

		$delete_poll=mysqli_query($con,"DELETE FROM poll WHERE userid='$user_id'");
		


//		 echo "<script> window.location.href='view_users.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='view_users.php' </script>";
	}
}

if(isset($_GET['video_id'])){
	$video_id=$_GET['video_id'];
	$select_video=mysqli_query($con,"SELECT video_image,video_path FROM video WHERE id='$video_id'");
	$row_video=mysqli_fetch_assoc($select_video);
	
	//echo $row_video['video_image'];
	//echo $row_video['video_path'];
	$delete=mysqli_query($con, "DELETE FROM video WHERE id='$video_id'");
	if($delete){
		unlink("../".$row_video['video_path']);
		unlink("../".$row_video['video_image']);
		$delete_rating=mysqli_query($con,"DELETE FROM `ratings` WHERE `videoid`='$video_id'");
		$delete_like=mysqli_query($con,"DELETE FROM `likes` WHERE `videoid`='$video_id'");
		$delete_comment=mysqli_query($con,"DELETE FROM `comments` WHERE `videoid`='$video_id'");

		echo "<script> window.location.href='view_videos.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='view_videos.php' </script>";
	}
}

if(isset($_GET['video_id_unapproved'])){
	$video_id=$_GET['video_id_unapproved'];
	$select_video=mysqli_query($con,"SELECT video_image,video_path FROM video WHERE id='$video_id'");
	$row_video=mysqli_fetch_assoc($select_video);
	$delete=mysqli_query($con, "DELETE FROM video WHERE id='$video_id'");
	if($delete){
		
		unlink("../".$row_video['video_path']);
		unlink("../".$row_video['video_image']);
		echo "<script> window.location.href='unapproved_videos.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='unapproved_videos.php' </script>";
	}
}

if(isset($_GET['category_id'])){
	$category_id=$_GET['category_id'];
	$delete=mysqli_query($con, "DELETE FROM category WHERE id='$category_id'");
	if($delete){
		$query="SELECT id,video_image,video_path FROM video WHERE category_id='$category_id'";
		$result=mysqli_query($con,$query);
		$arr=array();
		$arr3=array();
		$arr5=array();
		while($row=mysqli_fetch_array($result))
		{
			$arr[]=$row['id'];
			// $arr3[]=$row['video_image'];
			// $arr5[]=$row['video_path'];
			unlink("../".$row['video_path']);
			unlink("../".$row['video_image']);
			//echo $row['video_path'];
			//echo $row['video_image'];
		}
		$arr2=join("','",$arr);
		// $arr4=join("','",$arr3);
		// $arr6=join("','",$arr5);

			$delete_from_video=mysqli_query($con,"DELETE FROM video WHERE id IN ('$arr2')");
			$delete_rating=mysqli_query($con,"DELETE FROM `ratings` WHERE `videoid` IN ('$arr2') ");
			$delete_like=mysqli_query($con,"DELETE FROM `likes` WHERE `videoid` IN ('$arr2')");
			$delete_comment=mysqli_query($con,"DELETE FROM `comments` WHERE `videoid` IN ('$arr2')");
		
		echo "<script> window.location.href='view_category.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='view_category.php' </script>";
	}
}


if(isset($_GET['faq_id'])){
	$faq_id=$_GET['faq_id'];
	$delete=mysqli_query($con, "DELETE FROM faq WHERE id='$faq_id'");
	if($delete){
		echo "<script> window.location.href='faq.php' </script>";
	}else{
		echo "<script> alert('Sorry Somethong Went Wrong') </script>";
		echo "<script> window.location.href='faq.php' </script>";
	}
}

?>