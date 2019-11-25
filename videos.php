<?php include('header.php'); ?>

<?php 
   include 'verify_userstatus.php';
    if(isset($_GET['profile_id']))
    {
      $profile_id=$_GET['profile_id'];
    }
    else if(isset($_SESSION['id']))
      $profile_id=$_SESSION['id'];
    if($profile_id!=$_SESSION['id'])
    {
      echo "<script>window.location.href='index.php'</script>";
    }
    else
    {
  $query_profile="SELECT * FROM `users` WHERE `id`='$profile_id'";
  $result_profile=mysqli_query($con,$query_profile);
  $row_profile=mysqli_fetch_assoc($result_profile);


?>

  <section class="author-heading">
    <div class="section-padding">
      <div class="container">
        <div class="heading-top">
          <div class="author-cover-image background-bg" data-image-src="<?php echo $row_profile['cover_photo']; ?>">
            <div class="overlay"></div><!-- /.overlay -->
          </div><!-- /.author-cover-image -->
        </div><!-- /.heading-top -->
        <div class="heading-bottom">
          <div class="bottom-left col-xs-6">
            <div class="author-image"><img src="<?php echo $row_profile['passport_photo']; ?>" style="width: 180px; height: 180px;" alt="Author Image"></div>
            <h3 class="author-name"><?php echo $row_profile['fname']; ?></h3>
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
          <a class="active" href="videos.php?profile_id=<?php echo $profile_id; ?>">Videos</a>
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
          <a href="about.php?profile_id=<?php echo $profile_id; ?>">About</a>
        </nav><!-- /.author-page-links -->

        <div class="author-contents">
          <div class="row">
            <div class="col-sm-8">
              <div class="about-author">
                <div class="author-videos">

                  <center><h4 class="header-title">All Videos</h4></center>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Video Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Delete</th>
                                                    <!-- <th scope="col">Update</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $author_id=$row_profile['id'];
                                                    $select=mysqli_query($con,"SELECT * FROM video WHERE author_id='$author_id'");
                                                    while($row=mysqli_fetch_array($select)){
                                                ?>
                                                <tr>
                                                    <th style="vertical-align: middle;"><?php echo $row['video_name']; ?></th>
                                                    <td style="vertical-align: middle;"><?php echo $row['video_desc']; ?></td>
                                                    <td style="vertical-align: middle;">
                                                        <?php
                                                            $category_id=$row['category_id'];
                                                            $select_category=mysqli_query($con,"SELECT category_name FROM category WHERE id='$category_id'");
                                                            $row_category=mysqli_fetch_array($select_category);
                                                            echo $row_category['category_name']; 
                                                        ?>
                                                    </td>
                                                    <td style="vertical-align: middle;"><a href="user_delete_video.php?video_id=<?php echo $row['id']; ?>"><i class="ti-trash"></i></a></td>
                                                    <!-- <td><a href="user_update_video.php?id=<?php echo $row['id']; ?>">Update</a></td> -->
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                </div><!-- /.author-videos -->
              </div><!-- /.about-author -->
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
<?php 
  }
?>