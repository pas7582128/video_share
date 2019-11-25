<?php 
include('header.php');

$category_id=$_GET['category_id'];

?>

  



  <section class="video-contents category-sorting column-3">
    <div class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-8">
            <?php $select_category=mysqli_query($con,"SELECT category_name FROM category where id='$category_id'");
            $row_category=mysqli_fetch_array($select_category); ?>
            <h2 class="section-title">Category - <?php echo $row_category['category_name']; ?></h2>
            <div class="row">
              <?php $select_video=mysqli_query($con,"SELECT * FROM video where category_id='$category_id' AND `approved`=1");
              if(mysqli_num_rows($select_video)==0)
              {
                echo "No videos available<br>";
              }
              else
              {
              while($row_video=mysqli_fetch_array($select_video)){ ?>
              <div class="col-md-4 col-sm-6">
                <article class="post type-post">
                  <div class="entry-thumbnail">
                    <!-- <div class="play-btn"><a href="<?php echo $row_video['video_path']; ?>" style="color: blue;" class="iframe play-video"><i class="fa fa-play"></i></a></div> -->
                    <img src="<?php echo $row_video['video_image']; ?>" alt="Slider Image">
                    <a class="play-video iframe" href="<?php echo $row_video['video_path']; ?>" style="top: 33%; left: 44%;"><i class="fa fa-play"></i></a>
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
                      <span><a href="#"><i class="fa fa-comment-o"></i> <span class="count">
                        <?php 
                          $video_id1=$row_video['id'];
                          $query_comment="SELECT count(`id`) AS `no_of_comments` FROM `comments` WHERE `videoid`='$video_id1'";
                          $result_comment=mysqli_query($con,$query_comment);
                          $row_comment=mysqli_fetch_assoc($result_comment);
                          echo $row_comment['no_of_comments'];
                        ?>
                      </span></a></span>
                      <span><i class="fa fa-eye"></i> <span class="count">
                        <?php 
                          echo $row_video['n_views'];
                        ?>
                      </span></span>
                    </div><!-- /.entry-meta -->
                  </div><!-- /.emtry-content -->
                </article>
              </div>
              <?php }
              }
               ?>
            </div>
          </div>

<?php include('right_sidebar.php') ?>                    
        </div>
      </div>
    </div>
  </section>


<?php include('footer.php'); ?>