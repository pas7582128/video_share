<?php 
	include 'conn.php';
	include 'verify_userstatus.php';


		$tmp_comment=$_POST['comment'];
		$comment=mysqli_escape_string($con,$_POST['comment']);

		$userid=$_SESSION['id'];
		$videoid=$_POST['videoid'];

		// $comment="a";
		// $userid=5;
		// $videoid=5;
		// $parentid=12;

		if(isset($_POST['parentid']) && !empty($_POST['parentid'])){
			$parentid=$_POST['parentid'];
			$query1="SELECT `parentid` FROM `comments` WHERE id='$parentid'";
			$result1=mysqli_query($con,$query1);
			$row1=mysqli_fetch_assoc($result1);
			$parentid2=$row1['parentid'];
			if($parentid2==0)
			{
				$insert="INSERT INTO `comments` (`videoid`,`parentid`,`userid`,`comment`) VALUES ('$videoid','$parentid','$userid','$comment') ";
				$result=mysqli_query($con,$insert);

				if($result){
					$last_id=mysqli_insert_id($con);

					$userid=$_SESSION['id'];
					$query4="SELECT `username` FROM `users` WHERE id='$userid'"; 
					$result4=mysqli_query($con,$query4);
					$row4=mysqli_fetch_assoc($result4);
					$res=array("username"=>$row4['username'],
					"last_id"=>$last_id,
					"comment"=>$tmp_comment,
					"parentid"=>$parentid,
					"subparentid"=>0
					);
					
					echo json_encode($res);
				}
				else{
					echo mysqli_error($con);
				}

			}
			else
			{
				$query2="SELECT `userid` FROM `comments` WHERE id='$parentid'";
				$result2=mysqli_query($con,$query2);
				$row2=mysqli_fetch_assoc($result2);

					
					$userid2=$row2['userid'];
					$query3="SELECT `username` FROM `users` WHERE id='$userid2'";		
					$result3=mysqli_query($con,$query3);
					$row3=mysqli_fetch_assoc($result3);

				$tmp_comment=$row3['username'].'$'.$tmp_comment;
				$comment=$row3['username'].'$'.$comment;
				$insert="INSERT INTO `comments` (`videoid`,`parentid`,`subparentid`,`userid`,`comment`) VALUES ('$videoid','$parentid2','$parentid','$userid','$comment') ";
				
				$result=mysqli_query($con,$insert);
				if($result){
					$last_id=mysqli_insert_id($con);

					$userid=$_SESSION['id'];
					$query4="SELECT `username` FROM `users` WHERE id='$userid'"; 
					$result4=mysqli_query($con,$query4);
					$row4=mysqli_fetch_assoc($result4);
					$res=array("username"=>$row4['username'],
					"last_id"=>$last_id,
					"comment"=>$tmp_comment,
					"parentid"=>$parentid2,
					"subparentid"=>$parentid
					);
					
					echo json_encode($res);
				}
				else{
					echo mysqli_error($con);
				}
			}
			

			
		}
		else{
			$insert="INSERT INTO `comments` (`videoid`,`userid`,`comment`) VALUES ('$videoid','$userid','$comment') ";
			
			$result=mysqli_query($con,$insert);

			if($result){
				$last_id=mysqli_insert_id($con);

				$userid=$_SESSION['id'];
				$query4="SELECT `username` FROM `users` WHERE id='$userid'"; 
				$result4=mysqli_query($con,$query4);
				$row4=mysqli_fetch_assoc($result4);
				$res=array("username"=>$row4['username'],
				"last_id"=>$last_id,
				"comment"=>$tmp_comment,
				"subparentid"=>0);
				// $res['username']=$row4['username'];
				// $res['last_id']=$last_id;
				// $res['comment']=$tmp_comment;
				// $res->username=$row4['username'];
				// $res->last_id=$last_id;
				// $res->comment=$tmp_comment;



				echo json_encode($res);
			}
			else{
				echo mysqli_error($con);
			}


		}
		
		
		

?>