<?php 
	include 'conn.php';
	include 'verify_userstatus.php';
	$is_follow=$_POST['is_follow'];
	$followerid=$_SESSION['id'];
	$authorid=$_POST['authorid'];
	if($is_follow==1)
	{
		$query_follow="INSERT INTO `followers` (`authorid`,`followerid`) VALUES ('$authorid','$followerid')";
		$result_follow=mysqli_query($con,$query_follow);
	}
	else
	{
		$query_delete="DELETE FROM `followers` WHERE `authorid`='$authorid' AND `followerid`='$followerid'";
		$result_delete=mysqli_query($con,$query_delete);
	}
	

?>