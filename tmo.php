<?php 
include 'conn.php';
$delete=mysqli_query($con, "DELETE FROM category WHERE id='$category_id'");
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

		$delete_follow=mysqli_query($con,"DELETE FROM followers WHERE authorid='$userid' OR followerid='$followerid'");

		$delete_likes=mysqli_query($con,"DELETE FROM likes WHERE videoid IN (SELECT id FROM video WHERE author_id='$userid') OR userid='$userid'");

		$delete_ratings=mysqli_query($con,"DELETE FROM ratings WHERE videoid IN (SELECT id FROM video WHERE author_id='$userid') OR userid='$userid'");

		$delete_video=mysqli_query($con,"DELETE FROM video WHERE author_id='$userid'");
?>