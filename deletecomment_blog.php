<?php 
	include 'conn.php';
  	include 'verify_userstatus.php';
  

	$commentid=$_POST['commentid'];
	$query="DELETE FROM `blog_comments` WHERE `id`='$commentid' OR `parentid`='$commentid' OR `subparentid`='$commentid'";
	$result=mysqli_query($con,$query);

	if($result){
		echo "success";
	}
	else{
		echo "failure";
	}

?>