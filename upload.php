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

    if (isset($_POST['submit_video']))
    {
        // receive all input values from the form
        $video_name = $_POST['video_name'];
        $category_id = $_POST['category_id'];
        $description=$_POST['description'];
        $author_id=$_SESSION['id'];
        
        $targetDir = "uploads/";
        $allowTypes = array('video/mp4', 'video/flv', 'video/3gp', 'video/x-matroska');
        $imageAllowTypes = array('image/jpg', 'image/png', 'image/jpeg');

        $file_name = $_FILES['video']['name'];
        $tmp_name   = $_FILES['video']['tmp_name'];
        $size       = $_FILES['video']['size'];
        $type       = $_FILES['video']['type'];

        $image_name = $_FILES['video_image']['name'];
        $image_tmp_name   = $_FILES['video_image']['tmp_name'];
        $image_size       = $_FILES['video_image']['size'];
        $image_type       = $_FILES['video_image']['type'];

        if(in_array($type, $allowTypes))
        {
          if(in_array($image_type, $imageAllowTypes))
          {
        // File upload path
        $fileName = basename($_FILES['video']['name']);
        $targetFilePath = $targetDir . $fileName;

        $imageName = basename($_FILES['video_image']['name']);
        $targetImagePath = $targetDir . $imageName;
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        

        $imageType = pathinfo($targetImagePath,PATHINFO_EXTENSION);
        

            $insert = mysqli_query($con,"INSERT INTO video (video_name, video_image, video_desc, video_path, category_id, author_id) 
                      VALUES('$video_name', '$targetImagePath', '$description', '$targetFilePath', '$category_id', '$author_id')");

            if($insert)
            {
              move_uploaded_file($_FILES['video']['tmp_name'],$targetFilePath);
              move_uploaded_file($_FILES['video_image']['tmp_name'],$targetImagePath);
              echo "<script>window.location.href='upload.php'</script>";
            }
            else{
              echo mysqli_error($con);
              echo "<script>alert('Something Went Wrong!!!');</script>";
            }
          }else{
            echo "<script>alert('Only jpg, jpeg  or png formats are allowed for Cover Image');</script>";
            echo "<script>window.location.href='upload.php'</script>";
          }
        }else{
          echo "<script>alert('Only mp4, flv, 3gp, mkv formats are allowed for Videos');</script>";
          echo "<script>window.location.href='upload.php'</script>";
        }
    }

?>
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
                          $query_is_follow="SELECT `id` FROM `followers` WHERE `authorid`='$userid2' AND `followerid`='$userid2'";
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
                          
                        }
                        ?>
                        <span class="subs-count"><span class="count follow_count">
                          <?php 
                            $query_followers="SELECT count(`id`) AS `cnt_followers` FROM `followers` WHERE `authorid`='$userid2'";
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
          <a href="author.php">Home</a>
          <a href="videos.php">Videos</a>
          <!-- <a href="playlist.php">Playlist</a> -->
          <a class="active" href="upload.php">Upload</a>
          <a href="about.php">About</a>
        </nav><!-- /.author-page-links -->

        <div class="author-contents">
          <div class="row">
            <div class="col-sm-8">
              <div class="about-author">
                <div class="upload-video">
                  <form action="" method="post" enctype="multipart/form-data" class="upload-form">
                    <p class="form-element">
                      <label for="title">Video Title</label>
                      <input type="text" id="title" class="title form-control" name="video_name" required placeholder="Video Name">
                    </p>
                    <p class="form-element">
                      <label for="category">Category</label>
                      <select name="category_id" class="category form-control" id="category" required>
                        <option value="">Select a Category</option>
                        <?php
                        $select_category=mysqli_query($con,"SELECT * FROM category");
                        while($row_category=mysqli_fetch_array($select_category)){
                        ?>
                        <option value="<?php echo $row_category['id']; ?>"><?php echo $row_category['category_name']; ?></option>
                        <?php } ?>
                      </select>
                    </p>
                    <p class="form-element file-type">
                      <label for="image">Select Cover Image</label>
                      <input type="file" name="video_image" class="file form-control" required>
                      <span>Supported format jpg, jpeg or png; Max File size 2 MB</span>
                    </p>                    
                    <p class="form-element file-type">
                      <label for="file">Select Video</label>
                      <input type="file" name="video" class="file form-control" required>
                      <span>Supported format mp4, flv, 3gp, mkv; Max File size 50 MB</span>
                    </p>
                    <p class="form-element file-type">
                      <label for="description">Description</label>
                      <textarea name="description" class="description form-control" id="description" placeholder="Description" required></textarea>
                    </p>
                    <input type="submit" value="Upload Now" class="submit" name="submit_video">
                  </form>
                </div><!-- /.upload-video -->
              </div><!-- /.about-author -->
            </div>
<?php include('right_sidebar.php') ?>
          </div>
        </div>
      </div><!-- /.container -->
    </div><!-- /.section-padding -->
  </section><!-- /.author-page-contents -->



<?php include('footer.php'); ?>