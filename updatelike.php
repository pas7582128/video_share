<?php
	include 'conn.php';
	include 'verify_userstatus.php';
	$videoid=$_POST['videoid'];
	$like_cnt=$_POST['like_cnt'];
	$dislike_cnt=$_POST['dislike_cnt'];
	$userid=$_SESSION['id'];

	$query_select="SELECT `id`,`liked`,`disliked` FROM `likes` WHERE `userid`='$userid' AND `videoid`='$videoid'";
	$result_select=mysqli_query($con,$query_select);
	$row_select=mysqli_fetch_assoc($result_select);
	if(mysqli_num_rows($result_select))
	{
		//release like
		if($like_cnt==-1 && $dislike_cnt==0)
		{
			$query_delete="DELETE FROM `likes` WHERE `userid`='$userid' AND `videoid`='$videoid'";
			$result_delete=mysqli_query($con,$query_delete);
		}// release dislike
		else if($dislike_cnt==-1 && $like_cnt==0)
		{
			$query_delete="DELETE FROM `likes` WHERE `userid`='$userid' AND `videoid`='$videoid'";
			$result_delete=mysqli_query($con,$query_delete);
		}//
		else if($like_cnt==-1 && $dislike_cnt==1)
		{
			$query_update="UPDATE `likes` SET `liked`=0,`disliked`=1 WHERE `userid`='$userid' AND `videoid`='$videoid'";
			$result_update=mysqli_query($con,$query_update);
		}
		else if($like_cnt==1 && $dislike_cnt==-1)
		{
			$query_update="UPDATE `likes` SET `liked`=1,`disliked`=0 WHERE `userid`='$userid' AND `videoid`='$videoid'";
			$result_update=mysqli_query($con,$query_update);
		}
	}
	else
	{
		if($like_cnt==1)
		{
			$query_insert="INSERT INTO `likes` (`videoid`,`userid`,`liked`,`disliked`) VALUES ('$videoid','$userid',1,0)";

		}
		else if($dislike_cnt==1)
		{
			$query_insert="INSERT INTO `likes` (`videoid`,`userid`,`liked`,`disliked`) VALUES ('$videoid','$userid',0,1)";
		}
		$result_insert=mysqli_query($con,$query_insert);
	}

	$query_select2="SELECT count(`id`) AS `cnt_like` FROM `likes` WHERE `liked`=1 AND `videoid`='$videoid'";
	$result_select2=mysqli_query($con,$query_select2);

	$query_select3="SELECT count(`id`) AS `cnt_dislike` FROM `likes` WHERE `disliked`=1 AND `videoid`='$videoid'";
	$result_select3=mysqli_query($con,$query_select3);

	$row2=mysqli_fetch_assoc($result_select2);
	$row3=mysqli_fetch_assoc($result_select3);

	$cnt_like=$row2['cnt_like'];
	$cnt_dislike=$row3['cnt_dislike'];

	$res=array("cnt_like"=>$cnt_like,
			   "cnt_dislike"=>$cnt_dislike
				);
	
  echo json_encode($res);

?>