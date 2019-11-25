<?php 
	include 'conn.php';
	if(isset($_GET['email']) && isset($_GET['hash']))
	{
		$email=$_GET['email'];
		$hash=$_GET['hash'];
	}
	$check_email=mysqli_query($con,"SELECT hash FROM users WHERE email='$email'");
	if(mysqli_num_rows($check_email)==0)
	{
		echo "<script>alert('You have not registered.');</script>";
		echo "<script>window.location.href='index.php'</script>";
	}
	else 
	{
		$row=mysqli_fetch_assoc($check_email);
		if($row['hash']=='0')
		{
			echo "<script>alert('You have already registered.');</script>";
			echo "<script>window.location.href='index.php'</script>";
		}
		else
		{
			if($row['hash']==$hash)
			{
				$hash_update=mysqli_query($con,"UPDATE users SET  hash='0' WHERE email='$email'");
				echo "<script>alert('You are succesfully Verified. Login to continue');</script>";
				echo "<script>window.location.href='signin.php'</script>";
			}
			else
			{
				echo "<script>alert('Verification failed.');</script>";
				echo "<script>window.location.href='index.php'</script>";
			}
		}
	}

	$select_email="SELECT * FROM users WHERE email='$email' AND hash='$hash'";
	$result_email=mysqli_query($con, $select_email);
	if(mysqli_num_rows($email)==0){
		echo "<script>alert('Verification unsuccessfull.');</script>";
	}
	
?>