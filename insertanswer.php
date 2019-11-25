<?php 
	include 'conn.php';
	include 'verify_userstatus.php';
	$options=$_POST['options'];
	$userid=$_SESSION['id'];
	$questionid=$_POST['questionid'];
	$query="SELECT `id` FROM `poll` WHERE `questionid`='$questionid' AND `userid`='$userid'";
	$result=mysqli_query($con,$query);
	$num_of_rows=mysqli_num_rows($result);
	if($num_of_rows==0)
	{
		$query2="INSERT INTO `poll` (`questionid`,`userid`,`options`) VALUES ('$questionid','$userid','$options')";
		$result2=mysqli_query($con,$query2);
		

	}

  $query11="SELECT count(`id`) as `cnt1` FROM `poll` WHERE `questionid`='$questionid' AND `options`='a'";
  $result11=mysqli_query($con,$query11);
  $row11=mysqli_fetch_assoc($result11);
  $cnt1=$row11['cnt1'];

  $query12="SELECT count(`id`) as `cnt2` FROM `poll` WHERE `questionid`='$questionid' AND `options`='b'";
  $result12=mysqli_query($con,$query12);
  $row12=mysqli_fetch_assoc($result12);
  $cnt2=$row12['cnt2'];

  $query13="SELECT count(`id`) as `cnt3` FROM `poll` WHERE `questionid`='$questionid' AND `options`='c'";
  $result13=mysqli_query($con,$query13);
  $row13=mysqli_fetch_assoc($result13);
  $cnt3=$row13['cnt3'];

  $query14="SELECT count(`id`) as `cnt4` FROM `poll` WHERE `questionid`='$questionid' AND `options`='d'";
  $result14=mysqli_query($con,$query14);
  $row14=mysqli_fetch_assoc($result14);
  $cnt4=$row14['cnt4'];

  $query15="SELECT * FROM `survey` WHERE `id`='$questionid'";
  $result15=mysqli_query($con,$query15);
  $row15=mysqli_fetch_assoc($result15);
  $quest=$row15['survey_question'];
  $option_a=$row15['option_a'];
  $option_b=$row15['option_b'];
  $option_c=$row15['option_c'];
  $option_d=$row15['option_d'];

  $total_cnt=$cnt4+$cnt3+$cnt2+$cnt1;
  if($total_cnt==0)
  {
    $part1=0;
    $part2=0;
    $part3=0;
    $part4=0;
  }
  else
  {
    $part1=$cnt1*100/$total_cnt;
    $part2=$cnt2*100/$total_cnt;
    $part3=$cnt3*100/$total_cnt;
    $part4=$cnt4*100/$total_cnt;
  }

  $res=array("total_cnt"=>$total_cnt,
  			 "part1"=>$part1,
  			 "part2"=>$part2,
  			 "part3"=>$part3,
  			 "part4"=>$part4,
	         "cnt1"=>$cnt1,
	         "cnt2"=>$cnt2,
	         "cnt3"=>$cnt3,
	         "cnt4"=>$cnt4,
	         "quest"=>$quest,
	         "option_a"=>$option_a,
	         "option_b"=>$option_b,
	         "option_c"=>$option_c,
	         "option_d"=>$option_d,
           "questionid"=>$questionid
     		);
	
  echo json_encode($res);
?>