<?php 
	include 'conn.php';
	include 'verify_userstatus.php';
	

	$tmp_comment=$_POST['comment'];
	$tmp_comment2=$_POST['comment'];
	$comment=mysqli_escape_string($con,$_POST['comment']);

	
	$videoid=$_POST['videoid'];
	$commentid = $_POST['commentid'];

	$userid=$_SESSION['id'];

	


	$query = "SELECT * FROM `comments` WHERE `id`='$commentid'";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_assoc($result);
	$subparentid=$row['subparentid'];
	$comment_userid = $row['userid'];
	//echo $subparentid;

	if($subparentid!=0){

		$query2 = "SELECT `username` FROM `users` WHERE `id`='$comment_userid'";
		$result2 = mysqli_query($con,$query2);
		$row2 = mysqli_fetch_assoc($result2);
		$subparentname = $row2['username'];  
		$tmp_comment=$comment;
		$new_comment = $subparentname.'$'.$comment;

	}
	else{
		$tmp_comment=$comment;
		$new_comment = $comment;
	}

	$query3 = "UPDATE `comments` SET `comment`='$new_comment',`edited`=1 WHERE `id`='$commentid'";
	$result3 = mysqli_query($con,$query3);

	echo $tmp_comment2;

?>