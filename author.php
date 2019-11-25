<?php include('header.php'); ?>
<?php 
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
          <a class="active" href="author.php?profile_id=<?php echo $profile_id; ?>">Home</a>
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
          <a href="about.php?profile_id=<?php echo $profile_id; ?>">About</a>
        </nav><!-- /.author-page-links -->

        <div class="author-contents">
          <div class="row">
            <div class="col-sm-8">

              <?php $select_category=mysqli_query($con,"SELECT * FROM category");
                    while($row_category=mysqli_fetch_array($select_category)){ 
                      $category_id=$row_category['id'];
                    ?>
            <h2 class="section-title"><?php echo $row_category['category_name']; ?></h2><!-- /.section-title -->

            <div class="trending-slider owl-carousel owl-theme">
              <?php $select_video=mysqli_query($con,"SELECT * FROM video WHERE category_id='$category_id' AND `approved`=1 ORDER BY id DESC");
              if(mysqli_num_rows($select_video)==0)
              {
                echo "No videos available"."<br>";
              }
              else
              {

                while($row_video=mysqli_fetch_array($select_video)){ ?>
              <div class="item">
                <article class="post type-post">
                  <div class="entry-thumbnail">
                    <!-- <div class="play-btn"><a href="<?php echo $row_video['video_path']; ?>" style="color: blue;" class="iframe play-video"><i class="fa fa-play"></i></a></div> -->
                    <a href="video.php?video_id=<?php echo $row_video['id']; ?>">
                      <img src="<?php echo $row_video['video_image']; ?>" alt="Slider Image">
                    </a>
                    <!-- <img src="../../i.vimeocdn.com/video/61835890262e2.jpg?mw=960&amp;mh=540" alt="Entry Thumbnail"> -->
                  </div><!-- /.entry-thumbnail -->
                  <div class="entry-content">
                    <span class="category tag"><?php echo $row_category['category_name']; ?></span><!-- /.category -->
                    <h3 class="entry-title"><a href="video.php?video_id=<?php echo $row_video['id']; ?>"><?php echo $row_video['video_name']; ?> </a></h3><!-- /.entry-title -->
                    <div class="entry-meta">
                      <span class="author"><a href="author.php?profile_id=<?php echo $row_video['author_id']; ?>">
                        <?php
                        $author_id=$row_video['author_id']; 
                        $select_author=mysqli_query($con,"SELECT CONCAT(fname,' ',lname) AS author_name FROM users where id='$author_id'");
                        $row_author=mysqli_fetch_array($select_author); 
                        echo $row_author['author_name'];
                        ?></a></span><!-- /.author -->
                        <br>
                      <span><i class="fa fa-clock-o"></i> <time datetime="PT5M">
                        <?php 
                          date_default_timezone_set("Asia/Kolkata");
                             $datetime = new DateTime();
                              $datetime = $datetime->format('Y-m-d H:i:s');
                              $datetime2 = new DateTime($row_video['upload_date']);
                              $datetime2 = $datetime2->format('Y-m-d H:i:s');
                              // $datetime2 = $datetime2->format('Y-m-d H-i-s');
                              // echo "hello".$datetime2;
                          $ts1 = strtotime($datetime2);
                          $ts2 = strtotime($datetime);


                          $year1 = date('Y', $ts1);
                          $year2 = date('Y', $ts2);

                          $month1 = date('m', $ts1);
                          $month2 = date('m', $ts2);

                          $day1=date('d',$ts1);
                          $day2=date('d',$ts2);

                          $hour1=date('H',$ts1);
                          $hour2=date('H',$ts2);

                          $minute1=date('i',$ts1);
                          $minute2=date('i',$ts2);

                          

                          // $year=$year2-$year1;
                          // $month=$month2-$month1;
                          // $days=$day2-$day1;
                          // $hours=$hour2=$hour1;
                          // $minutes=$minute2-$minute1;
                          $diff=$ts2-$ts1;
                          $year=$diff/(60*60*24*365);
                          $month=12*$year;
                          $days=30*$month;
                          $weeks=$days/7;
                          $hours=24*$days;
                          $minutes=60*$hours;
                          $seconds=60*$minutes;
                           if((int)$year>0)
                           {
                            echo (int)$year." years ago";
                          }
                          else if((int)$month>0)
                          {
                            echo (int)$month." months ago";
                          }
                          else if((int)$weeks>0)
                          {
                            echo (int)$weeks." weeks ago";
                          }
                          else if((int)$days>0)
                          {
                            echo (int)$days." days ago";

                          }
                          else if((int)$hours>0)
                          {
                            echo (int)$hours." hours ago";
                          }
                          else if((int)$minutes>0)
                          {
                            // if((int)$minutes==0) $minutes=1;
                            echo (int)$minutes." minutes ago";


                          }
                          else
                          {
                            echo (int)$seconds." seconds ago";
                          }
                        ?>
                      </time></span>
                      <span><i class="fa fa-comment-o"></i> <span class="count">
                        <?php 
                          $video_id1=$row_video['id'];
                          $query_comment="SELECT count(`id`) AS `no_of_comments` FROM `comments` WHERE `videoid`='$video_id1'";
                          $result_comment=mysqli_query($con,$query_comment);
                          $row_comment=mysqli_fetch_assoc($result_comment);
                          echo $row_comment['no_of_comments'];
                        ?>
                      </span></span>
                      <span><i class="fa fa-eye"></i> <span class="count">
                        <?php 
                          echo $row_video['n_views'];
                        ?>
                      </span></span>
                    </div><!-- /.entry-meta -->
                  </div><!-- /.emtry-content -->
                </article><!-- /.type-post -->
              </div><!-- /.item -->
              <?php }
              }
              ?>
              </div> 
              <?php
            }
               ?>

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