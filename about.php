<?php
include('header.php'); 


  if(isset($_GET['profile_id']))
  {
    $profile_id=$_GET['profile_id'];
  }
  else
  {
    if(isset($_SESSION['id']))
    $profile_id=$_SESSION['id'];
  }

  $query_profile="SELECT * FROM `users` WHERE `id`='$profile_id'";
  $result_profile=mysqli_query($con,$query_profile);
  $row_profile1=mysqli_fetch_assoc($result_profile);

  $write_permission = "readonly";
  if(isset($_SESSION['id']) && isset($profile_id) && ($_SESSION['id']==$profile_id) ){
    $write_permission = "";
  }



$id=$row_profile1['id'];
$select=mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row=mysqli_fetch_array($select);

if(isset($_POST['update_profile']))
{
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $username=$_POST['username'];

  $update = mysqli_query($con,"UPDATE `users` SET fname='$fname', lname='$lname', username='$username' WHERE id='$id' ");

  if($update)
  {
    $_SESSION['fname']=$fname;
    $_SESSION['lname']=$lname;

    if($_FILES['profile_pic']['name'])
    {
      
      



      $error = array();
      $acceptable = array
      (
      'image/png',
      'image/jpg',
      'image/jpeg',
      /*
      'video/mp4',
      'application/pdf',
      'application/doc',
      'application/docx',
      'application/xls',
      'application/xlsx',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        */
      );
      


      $size=$_FILES['profile_pic']['size'];
      $type=$_FILES['profile_pic']['type'];
      if (!in_array($type, $acceptable)) {
          $error[] = "Invalid Type ".$type;
        }
        if($size>=2000000 || $size==0)
        {
          $error[] = "Image Size too large. File must be less than 2 megabytes.";
        }
        if(count($error)==0)
        {
            $img = mysqli_escape_string($con,$_FILES['profile_pic']['name']);
            $rnd = mt_rand(1,99999);
            $fnm = "uploads/profile_pic". $rnd . $img;
            $iname = str_replace(' ','_',$fnm);
            $tmp_name=$_FILES['profile_pic']['tmp_name'];
            $r=move_uploaded_file($tmp_name,$iname);
            
            $select_profile=mysqli_query($con,"SELECT passport_photo FROM users WHERE id='$id'");
            $row_profile=mysqli_fetch_assoc($select_profile);
            $profile_pic_name=$row_profile['passport_photo'];

            unlink($profile_pic_name);
            $update2=mysqli_query($con,"UPDATE users SET passport_photo='$iname' WHERE id='$id'");

          if($update2 && $r)
          {

              // echo "<script>window.location.href = 'about.php'; alert('Profile picture updated Successfully') </script>";
          }else{
              echo "<script> alert('Sorry!!! Something Went Wrong...') </script>";
          }
        }
        else
        {
             foreach($error as $err)
             {
                  echo '<script>alert("'.$err.'");</script>';
            }
            echo"<script type='text/javascript'>
                  window.location.href = 'about.php'
                 </script>";
            die();
        }

      
    }

    if($_FILES['cover_pic']['name'])
    {
      


      $error = array();
      $acceptable = array
      (
      'image/png',
      'image/jpg',
      'image/jpeg',
      /*
      'video/mp4',
      'application/pdf',
      'application/doc',
      'application/docx',
      'application/xls',
      'application/xlsx',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        */
      );
      
      $size=$_FILES['cover_pic']['size'];
      $type=$_FILES['cover_pic']['type'];
      if (!in_array($type, $acceptable)) {
          $error[] = "Invalid Type ".$type;
        }
        if($size>=2000000 || $size==0)
        {
          $error[] = "Image Size too large. File must be less than 2 megabytes.";
        }
        if(count($error)==0)
        {
            $img = mysqli_escape_string($con,$_FILES['cover_pic']['name']);
            $rnd = mt_rand(1,99999);
            $fnm = "uploads/cover_pic". $rnd . $img;
            $iname = str_replace(' ','_',$fnm);
            $tmp_name=$_FILES['cover_pic']['tmp_name'];
            $r=move_uploaded_file($tmp_name,$iname);
            
            $select_cover=mysqli_query($con,"SELECT cover_photo FROM users WHERE id='$id'");
            if(mysqli_num_rows($select_cover)!=0)
            {
              $row_cover=mysqli_fetch_assoc($select_cover);
            
              $cover_pic_name=$row_cover['cover_photo'];
              if(!empty($cover_pic_name))
              unlink($cover_pic_name);
            }
            
            //$update2=mysqli_query($con,"UPDATE users SET passport_photo='$iname' WHERE id='$id'");
            $update3=mysqli_query($con,"UPDATE users SET cover_photo='$iname' WHERE id='$id'");
          if($update3 && $r)
          {
              //echo "<script> alert('Cover image updated Successfully') </script>";
          }else{
              echo "<script> alert('Sorry!!! Something Went Wrong...') </script>";
          }
        }
        else
        {
             foreach($error as $err)
             {
                  echo '<script>alert("'.$err.'");</script>';
            }
            echo"<script type='text/javascript'>
                  window.location.href = 'about.php'
                 </script>";
            die();
        }
      
    }
    echo "<script>alert('Profile Updated Successfully');window.location.href = 'about.php';</script>";
  }
  else{
    echo "<script>alert('Something Went Wrong!!!, Please Try Again');</script>";
  }

}

?>
<style>
  input[type=submit]{
        background: #353641;
    border: 1px solid #353641;
    border-radius: 0;
    color: #b0bec5;
    cursor: pointer;
    font-family: 'Poppins';
    font-size: 15px;
    font-weight: 700;
    font-style: normal;
    line-height: 60px;
    margin-top: 15px;
    max-height: 60px;
    max-width: 100%;
    padding: 0 40px;
    text-decoration: none;
    text-transform: uppercase;
    position: inherit;
    width: inherit !important;
  }
  input[type="submit"]:hover {
    color: #d50000;
  }
  input[readonly] {
     cursor: default !important;
  }

</style>

<?php 
  $query_profile="SELECT * FROM `users` WHERE `id`='$profile_id'";
  $result_profile=mysqli_query($con,$query_profile);
  $row_profile1=mysqli_fetch_assoc($result_profile);

?>
  <section class="author-heading">
    <div class="section-padding">
      <div class="container">
        <div class="heading-top">
          <div class="author-cover-image background-bg" data-image-src="<?php echo $row_profile1['cover_photo']; ?>">
            <div class="overlay"></div><!-- /.overlay -->
          </div><!-- /.author-cover-image -->
        </div><!-- /.heading-top -->
        <div class="heading-bottom">
          <div class="bottom-left col-xs-6">
            <div class="author-image"><img src="<?php echo $row_profile1['passport_photo']; ?>" style="width: 180px; height: 180px;" alt="Author Image"></div>
            <h3 class="author-name"><?php echo $row_profile1['fname']; ?></h3>
          </div><!-- /.bottom-left -->

          <div class="bottom-right col-xs-6 text-right">
            <?php 
                          if(isset($_SESSION['id']))
                          {
                          $userid2=$_SESSION['id'];
                          $query_is_follow="SELECT `id` FROM `followers` WHERE `authorid`='$profile_id' AND `followerid`='$userid2'";
                          $result_is_follow=mysqli_query($con,$query_is_follow);
                          $row_is_follow=mysqli_fetch_assoc($result_is_follow);
                          if(mysqli_num_rows($result_is_follow))
                          { 
                            $is_follow=1;
                          }
                          else
                          {
                          
                            $is_follow=0;
                          }
                        ?>
                        <?php 
                          if($profile_id!=$userid2)
                          {
                        ?>
                        <button class="follow-btn is_follow follow<?php echo $is_follow; ?>" 
                          <?php 
                            if($is_follow==1){
                              echo 'style="background-color:lightgray;color:black;"';
                            }
                          ?>
                         >
                          <?php
                            if($is_follow==0)
                            {
                              echo "FOLLOW";
                            }
                            else
                            {
                              echo "FOLLOWED";
                            }
                          ?>
            
                        </button>
                        <?php 
                          }
                        }
                        ?>
                        <span class="subs-count"><span class="count follow_count">
                          <?php 
                            $query_followers="SELECT count(`id`) AS `cnt_followers` FROM `followers` WHERE `authorid`='$profile_id'";
                            $result_followers=mysqli_query($con,$query_followers);
                            $row_followers=mysqli_fetch_assoc($result_followers);
                            echo $row_followers['cnt_followers'];
                          ?>
                        </span> followers</span>
          </div><!-- /.bottom-right -->
        </div><!-- /.header-bottom -->
      </div><!-- /.container -->
    </div><!-- /.section-padding -->
  </section><!-- /.author-heading -->





  <section class="author-page-contents">
    <div class="section-padding">
      <div class="container">
        <nav class="author-page-links">
          <a href="author.php?profile_id=<?php echo $profile_id; ?>">Home</a>
          <?php 
            if(isset($_SESSION['id']) && $profile_id==$_SESSION['id']){
          ?>
          <a href="videos.php?profile_id=<?php echo $profile_id; ?>">Videos</a>
          <?php
            }
          ?>
          <!-- <a href="playlist.php?profile_id=<?php echo $profile_id; ?>">Playlist</a> -->
          <?php 
            if(isset($_SESSION['id']) && $profile_id==$_SESSION['id']){
          ?>
          <a href="upload.php?profile_id=<?php echo $profile_id; ?>">Upload</a>
          <?php
            }
          ?>
          <a class="active" href="about.php?profile_id=<?php echo $profile_id; ?>">About</a>
        </nav><!-- /.author-page-links -->

        <div class="author-contents">
          <div class="row">
            <div class="col-sm-8">
              <h2 class="section-title">Update Profile</h2>

              <form class="register-form" method="post" enctype="multipart/form-data">
                <p class="form-input">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" value="<?php echo $row['fname'] ?>" name="fname" <?php echo $write_permission?> required>
                </p>
                <p class="form-input">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" value="<?php echo $row['lname'] ?>" name="lname" <?php echo $write_permission?> >  
                </p>
                <p class="form-input">
                  <label for="email">Email</label>                                  
                  <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>" readonly required>
                </p>
                <p class="form-input">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" onfocus="this.blur()" <?php echo $write_permission?> readonly required>
                </p>
                <p class="form-input">
                  <label for="mobile">Mobile</label>
                  <input type="text" class="form-control" name="mobile" value="<?php echo $row['mobile'] ?>" readonly pattern="[0-9].{9}" required>
                </p><br>
                <p class="form-input">
                  <label for="profile_pic">Profile picture</label>
                  <input type="file" class="form-control" name="profile_pic" value="">
                </p>
                <p class="form-input">
                  <label for="cover_pic">Cover picture</label>
                  <input type="file" class="form-control" name="cover_pic" value="">
                </p>

                <!-- <p class="form-input">
                  <label for="passport_photo">Passport Size Photo</label>
                  <input type="file" class="form-control" name="passport_photo" required>
                </p>
                <p class="form-input">
                  <label for="aadhar_card">Aadhar Card Photo</label>
                  <input type="file" class="form-control" name="aadhar_card" required>
                </p>
                <p class="form-input">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </p>
                <p class="form-input">
                  <label for="password1">Confirm Password</label>
                  <input type="password" class="form-control" name="password1" placeholder="Confirm Password" required>
                </p> -->
                <?php
                  if($_SESSION['id']==$profile_id){
                ?>
                    <p class="submit-input">
                      <input type="submit" class="btn" name="update_profile" value="Update">
                    </p>
                <?php
                  }
                ?>

              </form>
            </div>

<?php include('right_sidebar.php') ?>
          </div>
        </div>
      </div><!-- /.container -->
    </div><!-- /.section-padding -->
  </section><!-- /.author-page-contents -->

<script type="text/javascript">
  $(document).on('click','.is_follow',function(e){
    var is_follow=$('button').hasClass('follow1');

    if(is_follow==1)
    {
      $(this).removeClass('follow1');
      $(this).addClass('follow0');
      $(this).removeAttr('style');
      $(this).text('FOLLOW');
    }
    else
    {
      $(this).removeClass('follow0');
      $(this).addClass('follow1');
      $(this).css({"color":"black","background-color":"lightgray"});
      $(this).text("FOLLOWED");
    }
    is_follow=1-is_follow;
    $.ajax({
               data: 'authorid='+<?php echo json_encode($profile_id); ?>+'&is_follow='+is_follow,
               type: "post",
               url: "updatefollow.php",
               success: function(jobj){
                  
                    var prev_cnt=parseInt($('.follow_count').text());
                    if(is_follow==1)
                    {

                      $('.follow_count').text(prev_cnt+1);
                    }
                    else
                    {
                      $('.follow_count').text(prev_cnt-1);
                    }
               }
    });    

  });

</script>

<?php include('footer.php'); ?>