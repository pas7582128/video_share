<?php 
	include 'conn.php';
  include 'verify_userstatus.php';
	$rating=$_POST['rating'];
	$videoid=$_POST['videoid'];
	$userid=$_SESSION['id'];

	$query="SELECT `id` FROM `ratings` WHERE `userid`='$userid' AND `videoid`='$videoid'";
	$result=mysqli_query($con,$query);
	$num_of_rows=mysqli_num_rows($result);
	if($num_of_rows==0)
	{
		$query2="INSERT INTO `ratings` (`videoid`,`userid`,`rating`) VALUES ('$videoid','$userid','$rating')";
		$result2=mysqli_query($con,$query2);
		

	}
	else
	{
		$query2="UPDATE `ratings` SET `rating`='$rating' WHERE `userid`='$userid' AND `videoid`='$videoid'";
		$result2=mysqli_query($con,$query2);
	}
	$query3="SELECT avg(`rating`) as `avg_rating` from `ratings` WHERE `videoid`='$videoid'";
	$result3=mysqli_query($con,$query3);
	$row3=mysqli_num_rows($result3);
	$avg_rating=$row3['avg_rating'];
	$avg_rating=round($avg_rating,2);

  $query11="SELECT count(`id`) as `cnt1` FROM `ratings` WHERE `videoid`='$videoid' AND `rating`=1";
  $result11=mysqli_query($con,$query11);
  $row11=mysqli_fetch_assoc($result11);
  $cnt1=$row11['cnt1'];

  $query12="SELECT count(`id`) as `cnt2` FROM `ratings` WHERE `videoid`='$videoid' AND `rating`=2";
  $result12=mysqli_query($con,$query12);
  $row12=mysqli_fetch_assoc($result12);
  $cnt2=$row12['cnt2'];

  $query13="SELECT count(`id`) as `cnt3` FROM `ratings` WHERE `videoid`='$videoid' AND `rating`=3";
  $result13=mysqli_query($con,$query13);
  $row13=mysqli_fetch_assoc($result13);
  $cnt3=$row13['cnt3'];

  $query14="SELECT count(`id`) as `cnt4` FROM `ratings` WHERE videoid='$videoid' AND `rating`=4";
  $result14=mysqli_query($con,$query14);
  $row14=mysqli_fetch_assoc($result14);
  $cnt4=$row14['cnt4'];

  $query15="SELECT count(`id`) as `cnt5` FROM `ratings` WHERE `videoid`='$videoid' AND `rating`=5";
  $result15=mysqli_query($con,$query15);
  $row15=mysqli_fetch_assoc($result15);
  $cnt5=$row15['cnt5'];

  $query16="SELECT avg(`rating`) AS `avg_rating` FROM `ratings` WHERE `videoid`='$videoid'";
  $result16=mysqli_query($con,$query16);
  $row16=mysqli_fetch_assoc($result16);
  $avg_rating=$row16['avg_rating'];

  $fraction_star_width=$avg_rating-(int)$avg_rating;
  $fraction_star_index=ceil($avg_rating);

  if($fraction_star_width==0)
  {
    $fraction_star_index+=1;
  }

  $total_cnt=$cnt5+$cnt4+$cnt3+$cnt2+$cnt1;
  if($total_cnt==0)
  {
    $part1=0;
    $part2=0;
    $part3=0;
    $part4=0;
    $part5=0;

  }
  else
  {
    $part1=$cnt1*100/$total_cnt;
    $part2=$cnt2*100/$total_cnt;
    $part3=$cnt3*100/$total_cnt;
    $part4=$cnt4*100/$total_cnt;
    $part5=$cnt5*100/$total_cnt;
  }

  $division = '<div class="bs-glyphicons"><span class="bs-glyphicons-list">';

	for($i=1;$i<$fraction_star_index;$i++){
		$division = $division.'<span class="glyphicon glyphicon-star star-color"></span>';
	}
   	
   	$division =$division.'<span class="glyphicon glyphicon-star star-color half"></span></span></div>';

  $res=array("avg_rating"=>round($avg_rating,2),
  			 "total_cnt"=>$total_cnt,
  			 "part1"=>$part1,
  			 "part2"=>$part2,
  			 "part3"=>$part3,
  			 "part4"=>$part4,
  			 "part5"=>$part5,
         "cnt1"=>$cnt1,
         "cnt2"=>$cnt2,
         "cnt3"=>$cnt3,
         "cnt4"=>$cnt4,
         "cnt5"=>$cnt5,
  			 "fraction_star_width"=>$fraction_star_width,
  			 "fraction_star_index"=>$fraction_star_index,
  			 "division"=>$division
				);
	
  echo json_encode($res);
?>