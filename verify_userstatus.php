<?php

  if(isset($_SESSION['id'])){
    $userid=$_SESSION['id'];
    $query_check = "SELECT * FROM `users` WHERE id='$userid'";
    $result_check = mysqli_query($con,$query_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if($row_check['status']==0){
      echo '<script>window.location.href="user_status.php"</script>';
    }


  }

  ?>