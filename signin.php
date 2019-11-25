<?php include ('header.php');

if(isset($_POST['wp-submit'])){
  $log=$_POST['log'];
  $password=$_POST['pwd'];
  $password=md5($password);
  $select=mysqli_query($con,"SELECT * FROM `users` WHERE (email='$log' OR username='$log') AND (password='$password')");
  $count=mysqli_num_rows($select);
  // echo "count".$count;
if($count>0)
{ 
  $row=mysqli_fetch_assoc($select);  
    $_SESSION['id']=$row['id'];
    $_SESSION['fname']=$row['fname'];
    $_SESSION['lname']=$row['lname'];
    $_SESSION['email']=$row['email'];
    $_SESSION['photo']=$row['passport_photo'];
    //echo $_SESSION['fname'];
    //print_r($_SESSION);
    //echo "<script>alert('');</script>";
    echo "<script>window.location.href='index.php'</script>";
  
}
else{
  echo "<script>alert('wrong email or password')</script>";
}
}

?>
<section class="form-elements style-2">
    <div class="section-paddin">
      <div class="right-panel">
        <h4>Have an account? Sign in</h4>
        <form class="sign-in-form" id="sign-in-form" method="post">
          <p class="form-input name">
            <input type="text" name="log" id="user_login" class="input form-control" value="" placeholder="Username / Email" required/>
          </p>
          <p class="form-input pswd">
            <input type="password" name="pwd" id="user_pass" class="input form-control" value="" placeholder="Password" required/>
          </p>
          <p class="submit-input">
            <input type="submit" name="wp-submit" id="wp-submit" class="btn" value="Log In Now" />
          </p>
          
          
          
        </form>
      </div><!-- /.right-panel -->

      <span class="bottom-text">
        Don’t Have an Account? <a href="register.php">Sign Up</a>
      </span>
    </div><!-- /.section-padding -->
  </section><!-- /.form-elements -->

<?php include 'footer.php'; ?>
