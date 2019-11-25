<?php
	include 'header_small.php';
	if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
    $query_check = "SELECT * FROM `users` WHERE id='$userid'";
    $result_check = mysqli_query($con,$query_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if($row_check['status']==1){
      echo '<script>window.location.href="index.php"</script>';
    }
    else{
      echo '<h2>Approval From Admin is pending.</h2>';
    }


  }

	
?>