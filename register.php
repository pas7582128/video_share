 <?php 
include ('header.php');

if(isset($_POST['signup-form-submit']))
{
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email=$_POST['email'];
  $username=$_POST['username'];
  $mobile=$_POST['mobile'];
  $password=$_POST['password'];
  $password1=$_POST['password1'];


  if($password==$password1){
    $select=mysqli_query($con,"SELECT * FROM `users` WHERE email='$email' OR username='$username'");
    $count=mysqli_num_rows($select);
    if($count>0)
    { 
      echo "<script>alert('This Email or Username is Already Present. Try Another E-mail OR Username');</script>";
    }else{

        $targetDir = "uploads/";
        $allowTypes = array('image/jpg', 'image/png', 'image/jpeg');

        $file_name = $_FILES['passport_photo']['name'];
        $tmp_name   = $_FILES['passport_photo']['tmp_name'];
        $size       = $_FILES['passport_photo']['size'];
        $type       = $_FILES['passport_photo']['type'];

        

        if(in_array($type, $allowTypes))
        {
                  $flag1=0;$flag2=0;

                  $passportName = basename($_FILES['passport_photo']['name']);
                  $targetPassportPath = $targetDir . $passportName;

                  $passportType = pathinfo($targetPassportPath,PATHINFO_EXTENSION);
                  move_uploaded_file($_FILES['passport_photo']['tmp_name'],$targetPassportPath);
                  

                  

                  
                    $hash = md5( rand(100,999999) );
                    $password=md5($password);
                    $insert = mysqli_query($con,"INSERT INTO `users`(`fname`,`lname`,`email`,`username`,`mobile`,`passport_photo`,`hash`,`password`) VALUES ('$fname','$lname','$email','$username', '$mobile', '$targetPassportPath','$hash','$password')");

                    if($insert)
                    {
                      echo "<script>alert('You have been Successfully Registered. ');</script>";
                      

                      echo "<script>window.location.href='signin.php'</script>";
                    }
                    else{
                      echo "<script>alert('');</script>";
                      echo mysqli_error($con);
                      echo "<script>alert('Something Went Wrong!!!, Please Try Again');</script>";
                    }
                  
            }else{
              echo "<script>alert('Only jpg, jpeg  or png formats are allowed for passport photo');</script>";
              echo "<script>window.location.href='register.php'</script>";
            }
    }
  }else{
    echo "<script>alert('Password And Confirmpassword Not Matched');</script>";
  }
}


?>

<section class="form-elements">
    <div class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-10">
            <div class="left-panel">
              <h2 class="section-title">Register Now</h2><!-- /.section-title -->
              
              <form class="register-form" method="post" enctype="multipart/form-data">
                <p class="form-input">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" placeholder="First Name" name="fname" pattern="[a-zA-Z]{1,}" required>
                </p>
                <p class="form-input">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" placeholder="Last Name" name="lname" pattern="[a-zA-Z]{1,}">  
                </p>
                <p class="form-input">
                  <label for="email">Email</label>                                  
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </p>
                <p class="form-input">
                  <label for="username">Username (3 to 15 characters including letters,digits, _ , - )</label>
                  <input type="text" class="form-control" name="username" placeholder="Username" pattern="^[a-z0-9_-]{3,15}$" required>
                </p>
                <p class="form-input">
                  <label for="mobile">Mobile</label>
                  <input type="text" class="form-control" name="mobile" placeholder="Enter Only Ten Digits" pattern="[0-9].{9}" required>
                </p>
                <br>
                <p class="form-input">
                  <label for="passport_photo">Passport Size Photo</label>
                  <input type="file" class="form-control" name="passport_photo" required>
                </p>
                <br>
                <p class="form-input">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Password" pattern="^\w{8,}$" required>
                </p>
                <p class="form-input">
                  <label for="password1">Confirm Password</label>
                  <input type="password" class="form-control" name="password1" pattern="^\w{8,}$" placeholder="Confirm Password" required>
                </p>
                <!-- <p class="checkbox">
                  <input name="rememberme" type="checkbox" class="rememberme pull-left" value="Remember Me" required /> 
                  I agree the 
                  <a href="#"> terms and conditions</a>
                </p> -->
                <p class="submit-input">
                  <input type="submit" class="btn" name="signup-form-submit" value="Register Now">
                  
                </p>

              </form>
            </div><!-- /.left-panel -->
          </div>

          <!-- <div class="col-sm-5">
            <div class="right-panel">
              <h4>Have an account? Sign in</h4>
              <form class="sign-in-form" id="sign-in-form" action="#" method="post">
                <p class="form-input">
                  <input type="text" name="log" id="user_login" class="input form-control" value="" placeholder="Username / Email" required/>
                </p>
                <p class="form-input">
                  <input type="password" name="pwd" id="user_pass" class="input form-control" value="" placeholder="Password" required/>
                </p>
                <p class="checkbox">
                  <input name="rememberme" type="checkbox" class="rememberme" value="Remember Me"/> 
                  Keep Me Signed in 
                  <a href="#" class="pull-right" title="Keep Me Signed in"> Forgot password?</a>
                </p>
                <p class="submit-input">
                  <input type="submit" name="wp-submit" id="wp-submit" class="btn" value="Log In" />
                  <span class="alt-methods">
                    Or Use
                    <a class="facebook" href="#"><i class="fa fa-facebook-official"></i></a>
                    <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                    <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                  </span>
                </p>
              </form>
            </div>--><!-- /.right-panel -->
          <!--</div> -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section-padding -->
  </section><!-- /.form-elements -->

<?php include 'footer.php'; ?>
