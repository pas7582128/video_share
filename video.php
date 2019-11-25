<?php 
    include 'verify_userstatus.php';
    if(!isset($_SESSION))
    {
      session_start();
    }
    $video_id1=$_GET['video_id'];
    

    if(isset($_SESSION['id']))
    {
      $cookie_name = $video_id1.'_'.$_SESSION['id'];
    }
    else
    {
      $cookie_name=$video_id1;
      
    }
    $cookie_value = 'no value';
     // 86400 = 1 day
    $flag=0;
    if(!isset($_COOKIE[$cookie_name])) {
        //echo "Cookie named '" . $cookie_name . "' is not set!";
        setcookie($cookie_name, $cookie_value,time()+60*30, "/"); //30 minute cookie
        $flag=1;
        //echo "<script>alert(".time().")</script>"; 

    } 
    else{
        //echo "<script>alert('nowhere')</script>"; 
    } 
include('header.php'); 

    if($flag==1)
    {
        $q3="UPDATE `video` SET `n_views`=`n_views`+1 WHERE id='$video_id1'";
        $res3=mysqli_query($con,$q3);
    }

$video_id=$_GET['video_id'];
if(isset($_SESSION['id'])){
  $author_id=$_SESSION['id'];
  
}

if(isset($_POST['add_comment']))
{
  $comment=$_POST['comment'];
  $insert=mysqli_query($con,"INSERT INTO comments (comment, author_id, video_id) VALUES ('$comment', '$author_id', '$video_id') ");
  if($insert)
  {
    echo "<script> window.location.href='video.php?video_id=$video_id' </script>";
  }
}

$select_video=mysqli_query($con,"SELECT * FROM video where id='$video_id'");
$row_video=mysqli_fetch_array($select_video) 
?>

<link rel="stylesheet" href="assets/css/star.css">
  <section class="blog-posts video-post">
    <div class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-8">
            <article class="post type-post format-standard">
              <div class="entry-thumbnail">
                <div id="post-slider" class="post-slider carousel slide">
                  <div class="carousel-inner">
                    <div class="item active">
                      <video width="750" height="500" controls>
                        <source src="<?php echo $row_video['video_path']; ?>" type="video/mp4">
                      </video>
                      <!-- <img src="<?php echo $row_video['video_image']; ?>" style="height:500px; width:900px; margin-bottom: 20px;" alt="Image">
                      <a class="iframe" href="<?php echo $row_video['video_path']; ?>"><i class="fa fa-play"></i></a> -->
                    <!-- </div>
                    <div class="item">
                      <img src="../../i.vimeocdn.com/video/6042531033d0c.jpg?mw=1280&amp;mh=1080" alt="Slider Image">
                      <a class="play-video iframe" href="https://vimeo.com/192598510"><i class="fa fa-play"></i></a>
                    </div>
                    <div class="item">
                      <img src="../../i.vimeocdn.com/video/6012685773d0c.jpg?mw=1280&amp;mh=1080" alt="Slider Image">
                      <a class="play-video iframe" href="https://vimeo.com/190558650"><i class="fa fa-play"></i></a>
                    </div>
                  </div> --><!-- /.carousel-inner -->
                  <!-- <a class="left carousel-control" href="#post-slider" role="button" data-slide="prev">
                    <i class="fa fa-angle-left fa-6" aria-hidden="true"></i>
                  </a>

                  <a class="right carousel-control" href="#post-slider" role="button" data-slide="next">
                    <i class="fa fa-angle-right fa-6" aria-hidden="true"></i>
                  </a>
                </div> --><!-- /#post-slider -->
              </div><!-- /.entry-thumbnail -->
                <br><br>
              <div class="entry-content">
                <div class="entry-meta">
                  <span><time>
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
                  <?php
                  $category_id=$row_video['category_id'];
                  $select_category=mysqli_query($con,"SELECT category_name FROM category where id='$category_id'");
                  $row_category=mysqli_fetch_array($select_category); 
                  ?>
                  <span class="category tag"><a href="category.php?<?php echo $row_video['category_id']; ?>"><?php echo $row_category['category_name']; ?></a></span>
                </div><!-- /.entry-meta -->

                <h2 class="entry-title"><?php echo $row_video['video_name']; ?></h2><!-- /.entry-title -->

                <div class="author-meta">
                  <div class="col-xs-7">
                    <div class="left-side media">
                      <?php
                      $author_id=$row_video['author_id'];
                      $authorid1=$author_id;
                      $select_author=mysqli_query($con,"SELECT * FROM users WHERE id='$author_id'");
                      $row_author=mysqli_fetch_array($select_author); 
                      ?>
                      <div class="author-avatar media-left"><img src="<?php echo $row_author['passport_photo']; ?>" alt="Avatar"></div>
                      <div class="author-details media-body">
                        <a href="author.php?profile_id=<?php echo $author_id; ?>" style="color:black;"><h3 class="name"><?php echo $row_author['fname']." ".$row_author['lname']; ?></h3></a><!-- /.name -->
                        <?php 
                          if(isset($_SESSION['id']))
                          {
                          $userid2=$_SESSION['id'];
                          $query_is_follow="SELECT `id` FROM `followers` WHERE `authorid`='$author_id' AND `followerid`='$userid2'";
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
                          if($authorid1!=$userid2)
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
                        <span class="follow-counter"><span class="count follow_count">
                          <?php 
                            $query_followers="SELECT count(`id`) AS `cnt_followers` FROM `followers` WHERE `authorid`='$author_id'";
                            $result_followers=mysqli_query($con,$query_followers);
                            $row_followers=mysqli_fetch_assoc($result_followers);
                            echo $row_followers['cnt_followers'];
                          ?>
                        </span> followers</span>
                      </div><!-- /.author-details -->
                    </div><!-- /.left-side -->
                  </div>

                  <?php
                    if(isset($_SESSION['id'])){ 
                      $userid=$_SESSION['id'];
                      $query_is_like="SELECT `liked`,`disliked` FROM `likes` WHERE `userid`='$userid' AND `videoid`='$video_id'";
                      $result_is_like=mysqli_query($con,$query_is_like);
                      $row_is_like=mysqli_fetch_assoc($result_is_like);
                      
                      if(mysqli_num_rows($result_is_like))
                      {
                          $val_like_b=$row_is_like['liked'];
                          $val_dislike_b=$row_is_like['disliked'];
                          if($val_like_b==1)
                          {
                            $val_like=1;
                            $val_dislike=0;
                          } 
                          else if($val_dislike_b==1)
                          {
                            $val_dislike=1;
                            $val_like=0;
                          }
                     }
                      else
                      {
                          $val_like=0;
                          $val_dislike=0;
                      }

                    

                    }
                  ?>

                  <?php

                  if(isset($_SESSION['id'])){
                    ?>
                  <div class="col-xs-5">
                    <div class="right-side">
                      <span class="view-counter"><span class="count">
                        <?php echo $row_video['n_views']; ?>
                      </span> Views</span>
                      <span class="like-count"><div class="like_btn"><i class="fa fa-thumbs-up like_btn_i like_btn_icon<?php echo $val_like;  ?>" <?php if($val_like==1) echo 'style="color:blue;"' ?> ></i>
                      <span class="count_like">
                        <?php

                          $query_likes="SELECT count(`id`) AS `cnt_likes` FROM `likes` WHERE `videoid`='$video_id' AND `liked`=1";
                          $result_likes=mysqli_query($con,$query_likes);
                          $row_likes=mysqli_fetch_assoc($result_likes);
                          echo $row_likes['cnt_likes'];
                          //echo " ".$val_like." ".$val_dislike." ";
                        ?>
                      </span></div></span>
                      <span class="dislike-count"><div class="dislike_btn"><i class="fa fa-thumbs-down dislike_btn_i dislike_btn_icon<?php echo $val_dislike; ?>" <?php if($val_dislike==1) echo 'style="color:blue;"' ?>></i>
                        <span class="count_dislike">
                        <?php

                          $query_dislikes="SELECT count(`id`) AS `cnt_dislikes` FROM `likes` WHERE `videoid`='$video_id'  AND `disliked`=1";
                          $result_dislikes=mysqli_query($con,$query_dislikes);
                          $row_dislikes=mysqli_fetch_assoc($result_dislikes);
                          echo $row_dislikes['cnt_dislikes'];
                        ?>
                      </span>
                      </div></span>
                    </div><!-- /.right-side -->
                  </div>

                  <?php
                    }
                    else{
                  ?>
                    <div class="col-xs-5">
                    <div class="right-side">
                      <span class="view-counter"><span class="count">
                        <?php echo $row_video['n_views']; ?>
                      </span> Views</span>
                      <span class="like-count"><div class="like_btn"><i class="fa fa-thumbs-up"></i>
                      <span class="count_like">
                        <?php

                          $query_likes="SELECT count(`id`) AS `cnt_likes` FROM `likes` WHERE `videoid`='$video_id' AND `liked`=1";
                          $result_likes=mysqli_query($con,$query_likes);
                          $row_likes=mysqli_fetch_assoc($result_likes);
                          echo $row_likes['cnt_likes'];
                          //echo " ".$val_like." ".$val_dislike." ";
                        ?>
                      </span></div></span>
                      <span class="dislike-count"><div class="dislike_btn"><i class="fa fa-thumbs-down"></i>
                        <span class="count_dislike">
                        <?php

                          $query_dislikes="SELECT count(`id`) AS `cnt_dislikes` FROM `likes` WHERE `videoid`='$video_id'  AND `disliked`=1";
                          $result_dislikes=mysqli_query($con,$query_dislikes);
                          $row_dislikes=mysqli_fetch_assoc($result_dislikes);
                          echo $row_dislikes['cnt_dislikes'];
                        ?>
                      </span>
                      </div></span>
                    </div><!-- /.right-side -->
                  </div>

                  <?php
                    }
                  ?>
                </div><!-- /.author-meta -->
                
                <p>
                  <?php echo $row_video['video_desc']; ?>
                </p>
                
              </div><!-- /.entry-content -->

              <!-- <div class="post-bottom">
                <div class="tags pull-left">
                  <a href="#">Video </a>
                  <a href="#">Music</a>
                  <a href="#">Funny</a>
                </div>

                <div class="post-social pull-right">
                  <button class="share-btn">Share <i class="fa fa-share-alt"></i></button>
                  <div class="btn-hover">
                    <a class="facebook" href="#"><i class="fa fa-facebook-square"></i> <span class="count">09</span></a>
                    <a class="pinterest" href="#"><i class="fa fa-pinterest"></i> <span class="count">09</span></a>
                    <a class="twitter" href="#"><i class="fa fa-twitter-square"></i> <span class="count">09</span></a>
                    <a class="google" href="#"><i class="fa fa-google-plus-square"></i> <span class="count">09</span></a>
                  </div> --><!-- /.btn-hover -->
                <!-- </div> --><!-- /.post-social -->
              <!-- </div> --><!-- /.post-bottom -->
            </article><!-- /.post -->


            <?php 

                      $check1="";
                      $check2="";
                      $check3="";
                      $check4="";
                      $check5="";
                      if(isset($_SESSION['id']))
                      {
                        $userid9=$_SESSION['id'];
                      
                      $query9="SELECT * FROM `ratings` WHERE `userid`='$userid9' AND `videoid`='$video_id'";
                      $result9=mysqli_query($con,$query9);
                      $row9=mysqli_fetch_assoc($result9);
                      $ratingvalue=$row9['rating'];
                      


                      if($ratingvalue>=1)
                      {
                        $check1="checked";
                      }
                      if($ratingvalue>=2)
                      {
                        $check2="checked";
                      }
                      if($ratingvalue>=3)
                      {
                        $check3="checked";
                      }
                      if($ratingvalue>=4)
                      {
                        $check4="checked";
                      }
                      if($ratingvalue>=5)
                      {
                        $check5="checked";
                      }
                    }
                      $query11="SELECT count(`id`) as `cnt1` FROM `ratings` WHERE `videoid`='$video_id' AND `rating`=1";
                      $result11=mysqli_query($con,$query11);
                      $row11=mysqli_fetch_assoc($result11);
                      $cnt1=$row11['cnt1'];

                      $query12="SELECT count(`id`) as `cnt2` FROM `ratings` WHERE `videoid`='$video_id' AND `rating`=2";
                      $result12=mysqli_query($con,$query12);
                      $row12=mysqli_fetch_assoc($result12);
                      $cnt2=$row12['cnt2'];

                      $query13="SELECT count(`id`) as `cnt3` FROM `ratings` WHERE `videoid`='$video_id' AND `rating`=3";
                      $result13=mysqli_query($con,$query13);
                      $row13=mysqli_fetch_assoc($result13);
                      $cnt3=$row13['cnt3'];

                      $query14="SELECT count(`id`) as `cnt4` FROM `ratings` WHERE videoid='$video_id' AND `rating`=4";
                      $result14=mysqli_query($con,$query14);
                      $row14=mysqli_fetch_assoc($result14);
                      $cnt4=$row14['cnt4'];

                      $query15="SELECT count(`id`) as `cnt5` FROM `ratings` WHERE `videoid`='$video_id' AND `rating`=5";
                      $result15=mysqli_query($con,$query15);
                      $row15=mysqli_fetch_assoc($result15);
                      $cnt5=$row15['cnt5'];

                      $query16="SELECT avg(`rating`) AS `avg_rating` FROM `ratings` WHERE `videoid`='$video_id'";
                      $result16=mysqli_query($con,$query16);
                      $row16=mysqli_fetch_assoc($result16);
                      $avg_rating=$row16['avg_rating'];

                      $fraction_star_width=$avg_rating-(int)$avg_rating;
                      $fraction_star_index=ceil($avg_rating);

                      if($fraction_star_width==0)
                      {
                        $fraction_star_index+=1;
                      }

                      $total_cnt=$cnt5+$cnt4+$cnt3+$cnt2+$cnt1;
                      if($total_cnt==0)
                      {
                        $part1=0;
                        $part2=0;
                        $part3=0;
                        $part4=0;
                        $part5=0;

                      }
                      else
                      {
                        $part1=$cnt1*100/$total_cnt;
                        $part2=$cnt2*100/$total_cnt;
                        $part3=$cnt3*100/$total_cnt;
                        $part4=$cnt4*100/$total_cnt;
                        $part5=$cnt5*100/$total_cnt;
                      }

                      
                    ?>
                    <?php 
                      if(isset($_SESSION['id']))
                      {
                    ?>
                    <div class="row">
                      <div class="col-md-6">
                        
                        <form id="myForm">


                          <div class="stars">
                              <input type="radio" name="star" class="user_rating star-1" id="star-1" value="1<?php echo $video_id; ?>"  <?php echo $check1; ?> />
                              <label class="star-1" for="star-1">1</label>
                              <input type="radio" name="star" class="user_rating star-2" id="star-2" value="2<?php echo $video_id; ?>" <?php echo $check2; ?>  />
                              <label class="star-2" for="star-2">2</label>
                              <input type="radio" name="star" class="user_rating star-3" id="star-3" value="3<?php echo $video_id; ?>" <?php echo $check3; ?> />
                              <label class="star-3" for="star-3">3</label>
                              <input type="radio" name="star" class="user_rating star-4" id="star-4" value="4<?php echo $video_id; ?>" <?php echo $check4; ?>  />
                              <label class="star-4" for="star-4">4</label>
                              <input type="radio" name="star" class="user_rating star-5" id="star-5" value="5<?php echo $video_id; ?>" <?php echo $check5; ?>  />
                              <label class="star-5" for="star-5">5</label>
                              <span></span>
                          </div>
                      </form>
                    </div>
                  </div>
                  <?php 
                    }
                  ?>

                  <div class="row">
                    <div class="col-xs-12 col-md-12">
                    <div class="well well-sm">
                        <div class="row">
                          <div class="mycss">
                          <style type="text/css" scoped>
                            .half {
                                position:relative;
                            }

                            .half:after {
                                content:'';
                                position:absolute;
                                z-index:1;
                                background:#f5f5f5;
                                width: 100%;
                                height: 100%;
                                left: <?php echo $fraction_star_width*100 -3; ?>%;
                            }
                          </style>
                          </div>
                            <div class="col-xs-12 col-md-4 text-center">
                                <h1 class="rating-num">
                                    <?php
                                      echo round($avg_rating,2);
                                    ?>
                                    </h1>
                                <div class="rating">
                                    
                                    <div class="bs-glyphicons">
                                      <span class="bs-glyphicons-list">
                                          
                                          <?php
                                          for ($ind=1; $ind < $fraction_star_index; $ind++)
                                          {

                                          ?>
                                          <span class="glyphicon glyphicon-star star-color"></span>
                                          <?php
                                          }
                                          ?>
                                          <span class="glyphicon glyphicon-star star-color half"></span>
                                          <!-- <span class="glyphicon glyphicon-star star-color"></span>
                                          <span class="glyphicon glyphicon-star star-color"></span>
                                          <span class="glyphicon glyphicon-star star-color"></span>
                                          <span class="glyphicon glyphicon-star star-color half"></span> -->
                                      </span>
                                  </div>

                                </div>
                                <div>
                                    
                                    Total
                                    <span class="glyphicon glyphicon-user"></span>
                                    <span class="total_cnt">
                                    <?php 
                                      echo $total_cnt;
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="row rating-desc">
                                    <div class="col-xs-3 col-md-3 text-right">
                                        <span class="glyphicon glyphicon-star">5</span>
                                    </div>
                                    <div class="col-xs-8 col-md-7">
                                        <div class="progress progress-striped">
                                            <div class="progress-bar progress-bar-success part5" role="progressbar" aria-valuenow="20"
                                                aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part5?>%">
                                                <span class="sr-only"><?php echo $part5?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                      <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <div class="col-md-1 rating_cnt_part5">
                                    <?php echo $cnt5; ?>
                                    </div>
                                    <!-- end 5 -->
                                    <div class="col-xs-3 col-md-3 text-right">
                                        <span class="glyphicon glyphicon-star">4</span>
                                    </div>
                                    <div class="col-xs-8 col-md-7">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success part4" role="progressbar" aria-valuenow="20"
                                                aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part4?>%">
                                                <span class="sr-only"><?php echo $part4?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                      <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <div class="col-md-1 rating_cnt_part4">
                                    <?php echo $cnt4; ?>
                                    </div>
                                    <!-- end 4 -->
                                    <div class="col-xs-3 col-md-3 text-right">
                                        <span class="glyphicon glyphicon-star">3</span>
                                    </div>
                                    <div class="col-xs-8 col-md-7">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info part3" role="progressbar" aria-valuenow="20"
                                                aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part3?>%">
                                                <span class="sr-only"><?php echo $part3?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                      <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <div class="col-md-1 rating_cnt_part3">
                                    <?php echo $cnt3; ?>
                                    </div>
                                    <!-- end 3 -->
                                    <div class="col-xs-3 col-md-3 text-right">
                                        <span class="glyphicon glyphicon-star">2</span>
                                    </div>

                                    <div class="col-xs-8 col-md-7">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning part2" role="progressbar" aria-valuenow="20"
                                                aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part2?>%">
                                                <span class="sr-only"><?php echo $part2?>%</span>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-1">
                                      <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <div class="col-md-1 rating_cnt_part2">
                                    <?php echo $cnt2; ?>
                                    </div>

                                    <!-- end 2 -->
                                    <div class="col-xs-3 col-md-3 text-right">
                                        <span class="glyphicon glyphicon-star">1</span>
                                    </div>
                                    <div class="col-xs-8 col-md-7">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger part1" role="progressbar" aria-valuenow="80"
                                                aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $part1?>%">
                                                <span class="sr-only"><?php echo $part1?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                      <span class="glyphicon glyphicon-user"></span>
                                    </div>
                                    <div class="col-md-1 rating_cnt_part1">
                                    <?php echo $cnt1; ?>
                                    </div>
                                    <!-- end 1 -->
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                  </div>
                  </div>





            <h2 class="section-title">Related Videos</h2><!-- /.section-title -->

            <div class="related-videos-slider owl-carousel owl-theme">
              <?php $select_video=mysqli_query($con,"SELECT * FROM video where category_id='$category_id' AND `approved`=1 AND id!='$video_id1'");
              if(mysqli_num_rows($select_video)==0)
              {
                echo "No videos available<br>";
              }
              else
              {
              while($row_video=mysqli_fetch_array($select_video)){ ?>
              <div class="item">
                <div class="row">
              
              <div class="col-md-12 col-sm-6">
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
                      <span class="author"><a href="#">
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
             
            </div>
          </div><!-- /.item -->
           <?php }
            }
            ?>
        </div><!-- /.related-videos-slider -->



            <div class="comments" style="width: 100%;">
                <h2 class="section-title">Comments</h2>
                <?php 
                    if(isset($_SESSION['id'])){
                ?>
                <div class="respond">

                  <h2 class="title">Leave a Comment</h2>
                  <form method="post" class="comment-form comment_form_main" id="comment_form_main">
                    <textarea id="comment" class="form-control comment_box" name="comment" placeholder="Comment*" rows="2" required></textarea>
                    <input type="hidden" name="videoid" value="<?php echo $video_id; ?>">
                    <button name="submit_comment" class="btn submit_btn" id="submit_comment" type="button" value="Post Comment">Post</button>
                    
                  </form><!-- /.comment-form -->
                </div><!-- /.respond -->
                <?php 
                    }
                ?>
                <ol class="comment-list main_comment_list">
                  <?php 
                    $query5="SELECT * FROM `comments` WHERE videoid='$video_id' AND parentid=0 ORDER BY id desc";
                    $result5=mysqli_query($con,$query5);
                    while($row5=mysqli_fetch_array($result5)){
                      $userid3=$row5['userid'];
                      $query_img=mysqli_query($con,"SELECT passport_photo FROM users WHERE id='$userid3'");
                      $row_img=mysqli_fetch_assoc($query_img);
                  ?>
                  <li class="comment parent media" id="<?php echo 'li'.$row5['id']; ?>">
                    <div class="comment-item">
                      <div class="author-avatar media-left">
                        <img src="<?php echo $row_img['passport_photo']; ?>" alt="Comment Authors">
                      </div><!-- /.author-avatar -->
                      <div class="comment-body media-body">
                        <div class="comment-metadata">
                          <span class="name">
                          <?php
                              $comment_userid=$row5['userid'];
                              $query6="SELECT `username` FROM `users` WHERE id='$comment_userid'";
                              $result6=mysqli_query($con,$query6);
                              $row6=mysqli_fetch_assoc($result6);
                          ?> 
                          <a href="#">
                            <?php 
                              echo $row6['username'];
                            ?>
                          </a>
                          <?php

                          ?>
                          </span>
                          <?php
                            if(isset($_SESSION['id'])){
                          ?>
                          <button class="btn reply pull-right reply_btn1" id="reply_btn" name="reply_btn" value="<?php echo 'close'.$row5['id'];?>">Reply</button>
                          <?php 
                            if($_SESSION['id']==$row5['userid']){
                          ?>
                          <button class="btn reply pull-right delete_btn" id="delete_btn" name="delete_btn" value="<?php echo $row5['id'];?>">Delete</button>
                          <button class="btn reply pull-right update_btn update_btn1 update_btn_<?php echo $row5['id']; ?>" id="update_btn" name="update_btn" value="<?php echo $row5['id'].'$'.$row5['comment'];?>">Update</button>
                          <?php 
                            }
                          }
                          ?>
                          <span class="time">
                            <time datetime="2017-02-09 21:00">
                            <!-- Feb 09, 2017 at 21:37 -->
                            <?php 
                              //echo $row5['date_time'];
                              $datetime5=new DateTime($row5['date_time']);
                              $datetime5=$datetime5->format('F d\, Y \a\t g:ia');
                              echo $datetime5;
                              if($row5['edited']==1)
                              {
                                echo '<span class="edit'.$row5['id'].'" style="color:blue;"> (edited)</span> ';
                              }
                              else
                              {
                                echo '<span class="edit'.$row5['id'].'" style="color:blue;"></span>';
                              }
                            ?>
                            </time> 
                          </span>
                        </div><!-- /.comment-metadata -->
                        <p class="description<?php echo $row5['id']; ?>">
                          <?php
                            echo $row5['comment'];
                          ?>
                        </p>

                      </div><!--/.comment-body-->

                      <ol class="children child_comment_list<?php echo $row5['id']; ?>">
                        <?php 
                            $pid=$row5['id'];
                            $query7="SELECT * FROM `comments` WHERE parentid='$pid' ORDER BY id asc";
                            $result7=mysqli_query($con,$query7);
                            echo mysqli_error($con);
                            while($row7=mysqli_fetch_array($result7)){
                              $userid3=$row7['userid'];
                              $query_img=mysqli_query($con,"SELECT passport_photo FROM users WHERE id='$userid3'");
                              $row_img=mysqli_fetch_assoc($query_img);
                        ?>
                        <li class="comment media lisub<?php echo $row7['subparentid']; ?>" id="<?php echo 'li'.$row7['id']; ?>">
                          <div class="comment-item">
                            <div class="author-avatar media-left">
                              <img src="<?php echo $row_img['passport_photo']; ?>" alt="Comment Authors">
                            </div><!-- /.author-avatar -->
                            <div class="comment-body media-body">
                              <div class="comment-metadata">
                                <span class="name">
                                  <?php
                                      $comment_userid=$row7['userid'];
                                      $query8="SELECT `username` FROM `users` WHERE id='$comment_userid'";
                                      $result8=mysqli_query($con,$query8);
                                      $row8=mysqli_fetch_assoc($result8);
                                  ?> 
                                  <a href="#">
                                    <?php 
                                      echo $row8['username'];
                                    ?>
                                  </a>
                                  <?php

                                  ?>
                                </span>
                                <?php
                                  if(isset($_SESSION['id'])){
                                ?>
                                <button class="btn reply reply_to_reply pull-right reply_btn2" id="reply_btn" name="reply_btn" value="<?php echo 'close'.$row7['id'];?>">Reply</button>
                                <?php 
                                  if($_SESSION['id']==$row7['userid']){
                                ?>
                                <button class="btn reply pull-right delete_btn" id="delete_btn" name="delete_btn" value="<?php echo $row7['id'];?>">Delete</button>
                                <?php
                                  $comment_in_update=$row7['comment'];
                                  if(strpos($comment_in_update,'$')==false)
                                  {
                                      //echo $comment_in_update;
                                  }
                                  else
                                  {
                                  
                                  $username7=strtok($comment_in_update,'$');
                                  //echo "<span style='color:blue;'>@".$username7."</span><br>";
                                  $username7=strtok('$');
                                  $comment_in_update=$username7;
                                  }
                                ?>
                                <button class="btn reply pull-right update_btn update_btn2 update_btn_<?php echo $row7['id']; ?>" id="update_btn" name="update_btn" value="<?php echo $row7['id'].'$'.$comment_in_update;?>">Update</button>
                                <?php 
                                  }
                                }  
                                ?>
                                <span class="time">
                                  <time datetime="2017-02-09 21:00">
                                  <!-- Feb 09, 2017 at 21:37 -->
                                  <?php 
                                    //echo $row5['date_time'];
                                    $datetime7=new DateTime($row7['date_time']);
                                    $datetime7=$datetime7->format('F d\, Y \a\t g:ia');
                                    echo $datetime7;
                                    if($row7['edited']==1)
                                    {
                                      echo '<span class="edit'.$row7['id'].'" style="color:blue;"> (edited) </span>';
                                    }
                                    else
                                    {
                                      echo '<span class="edit'.$row7['id'].'" style="color:blue;"></span>';
                                    }
                                  ?>
                                  </time> 
                                </span>

                              </div><!-- /.comment-metadata -->
                              <?php
                                  $comment7=$row7['comment'];
                                  if(strpos($comment7,'$')==false)
                                  {
                                      //echo $comment7;
                                  }
                                  else
                                  {
                                  
                                  $username7=strtok($comment7,'$');
                                  echo "<span style='color:blue;'>@".$username7."</span><br>";
                                  $username7=strtok('$');
                                  $comment7=$username7;
                                  }
                                ?>
                              <p class="description<?php echo $row7['id'];?>">
                                <?php echo $comment7;?>
                              </p>
                            </div><!--/.comment-body-->
                          </div><!-- /.comment-item -->
                        </li>
                        <?php
                            }
                        ?>
                      </ol>
                      
                    </div><!-- /.comment-item -->
                  </li>
                  <?php
                    }
                  ?>
                </ol>
                
            </div><!-- /.comments -->

          </div>

<?php include('right_sidebar.php') ?>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.section-padding -->
  </section><!-- /.video-post -->

<script type="text/javascript">
  
     $(document).on('click','#submit_comment',function(e) {
        var data = $(".comment_form_main").serialize();
        
        var tmp_comment=$('#comment').val();
        if(tmp_comment=="")
        {

        }
        else
        {
        $.ajax({
               data: data,
               type: "post",
               url: "insertcomment.php",
               success: function(jobj){
                    //alert(jobj);
                    // var response=json.parse(jobj);
                    
                    var response=$.parseJSON(jobj);
                    <?php
                     if(isset($_SESSION['photo']))
                     {
                       $img=$_SESSION['photo']; 
                     }
                    ?>
                    var photo=<?php if(isset($_SESSION['photo']))echo json_encode($img); else echo "null"; ?>;
                    //alert(photo);

                    $('.main_comment_list').prepend('<li class="comment parent media" id="li'+response['last_id']+'">'+
                    '<div class="comment-item">'+
                      '<div class="author-avatar media-left">'+
                        '<img src="'+photo+'" alt="Comment Authors">'+
                      '</div><!-- /.author-avatar -->'+
                      '<div class="comment-body media-body">'+
                        '<div class="comment-metadata">'+
                          '<span class="name">'+
                          '<a href="#">'+
                            response['username']+
                         ' </a>'+
                          '</span>'+
                          '<button class="btn reply pull-right reply_btn1" id="reply_btn" name="reply_btn" value="close'+response['last_id']+'">Reply</button>'+
      
                          '<button class="btn reply pull-right delete_btn" id="delete_btn" name="delete_btn" value="'+response['last_id']+'">Delete</button>'+
                         ' <button class="btn reply pull-right update_btn update_btn1 update_btn_'+response['last_id']+'" id="update_btn" name="update_btn" value="'+response['last_id']+'$'+response['comment']+'">Update</button>'+
                          
                          '<span class="time">'+
                            '<time datetime="2017-02-09 21:00">'+
                            '<!-- Feb 09, 2017 at 21:37 -->'+
                            '<?php 
                              //echo $row5['date_time'];
                              $datetime5=new DateTime();
                              $datetime5=$datetime5->format('F d\, Y \a\t g:ia');
                              echo $datetime5;
                            ?>'+
                            '<span class="edit'+response['last_id']+'" style="color:blue;"></span>'+
                            '</time> '+
                          '</span>'+
                        '</div><!-- /.comment-metadata -->'+
                        '<p class="description'+response['last_id']+'">'+
                          response['comment']+
                        '</p>'+
                      '</div><!--/.comment-body-->'+

                      '<ol class="children child_comment_list'+response['last_id']+'">'+
                      '</ol>'+
                    '</div><!-- /.comment-item -->'+
                  '</li>');
               }
              


      });
      }
        $('.comment_box').val("");
        //var txt="";
        //var txt=".respond"+data['parentid'];
        //$(txt).remove();

    });

     $(document).on('click','.submit_comment_child',function(e) {
          var data = $(".comment_form_child").serialize();

          var data2 = $(this).val();
          //alert(data2);
          data3 = ".respond"+data2.substr(4);
          var tmp_comment=$('#comment2').val();
          

          //alert(data2.parentid);
          
          if(tmp_comment=="")
          {

          }
          else
          {
                $(data3).remove(); 
                  $.ajax({
                         data: data,
                         type: "post",
                         url: "insertcomment.php",
                         success: function(jobj){
                              
                              var response=$.parseJSON(jobj);
                              var comment=response['comment'];
                              var username="";
                              var comment1=comment;

                              <?php if(isset($_SESSION['photo']))$img=$_SESSION['photo']; ?>
                              var photo=<?php if(isset($_SESSION['photo']))echo json_encode($img); else echo "null";?>;

                              if(comment.indexOf('$')!=-1)
                              {
                                  username="@"+comment.slice(0,comment.indexOf('$'));
                                  comment1=comment.slice(comment.indexOf('$')+1);
                              }
                              //alert(username+" "+comment1+" "+response['parentid']);
                              var class_s=".child_comment_list"+response['parentid'];
                              $(class_s).append('<li class="comment media lisub'+response['subparentid']+'" id="li'+response['last_id']+'">'+
                                  '<div class="comment-item">'+
                                    '<div class="author-avatar media-left">'+
                                      '<img src="'+photo+'" alt="Comment Authors">'+
                                    '</div><!-- /.author-avatar -->'+
                                    '<div class="comment-body media-body">'+
                                      '<div class="comment-metadata">'+
                                        '<span class="name">'+
                                          
                                          '<a href="#">'+
                                            response['username']+
                                          '</a>'+
                                          
                                        '</span>'+
                                        '<button class="btn reply reply_to_reply pull-right reply_btn2" id="reply_btn" name="reply_btn" value="close'+response['last_id']+'">Reply</button>'+
                                        
                                        '<button class="btn reply pull-right delete_btn" id="delete_btn" name="delete_btn" value="'+response['last_id']+'">Delete</button>'+
                                        '<button class="btn reply pull-right update_btn update_btn2 update_btn_'+response['last_id']+'" id="update_btn" name="update_btn" value="'+response['last_id']+'$'+comment1+'">Update</button>'+
                                        
                                        '<span class="time">'+
                                          '<time datetime="2017-02-09 21:00">'+
                                          '<!-- Feb 09, 2017 at 21:37 -->'+
                                          '<?php 
                                            //echo $row5['date_time'];
                                            $datetime7=new DateTime();
                                            $datetime7=$datetime7->format('F d\, Y \a\t g:ia');
                                            echo $datetime7;

                                          ?>'+
                                          '<span class="edit'+response['last_id']+'" style="color:blue;"></span>'+
                                          '</time> '+
                                        '</span>'+

                                      '</div><!-- /.comment-metadata -->'+
                                      '<span style="color:blue;">'+
                                        username+
                                        '</span><br>'+
                                      '<p class="description'+response['last_id']+'">'+
                                        
                                        
                                        
                                        comment1+

                                      '</p>'+
                                    '</div><!--/.comment-body-->'+
                                  '</div><!-- /.comment-item -->'+
                                '</li>');
                         }
                });
          }
          $('.comment_box').val("");
                  

      });

     $(document).on('click','.reply_btn1',function(){
     // $('.reply').click(function(){

        var data=$(this).val();
        var txt=".respondaaa";
        $(txt).remove();
        var tmp1="Post"+data.substr(5);
        var tmp2=$('.submit_comment_child').val();
        if(tmp2==tmp1)
        {

        }
        else
        {
            //var divid='#li'+data.substr(5);
            var divid=".child_comment_list"+data.substr(5);

            $(divid).before('<div class="respond respondaaa respond'+data.substr(5)+'">'+

                    '<h2 class="title">Leave a reply</h2>'+
                    '<form method="post" class="comment_form_child" id="comment_form">'+
                      '<textarea id="comment2" class="form-control comment_box" name="comment" placeholder="Reply*" rows="4" required></textarea>'+
                      '<input type="hidden" name="parentid" value="'+data.substr(5)+'">'+
                      '<input type="hidden" name="videoid" value="<?php echo $video_id; ?>">'+
                      '<button name="submit_comment_child" class="btn submit_btn submit_comment_child" id="submit_comment_child" type="button" value="Post'+data.substr(5)+'">Post</button>'+
                      '<button type="button" name="cancel_comment" class="btn cancel_btn" id="cancel_comment" value="Cancel Comment'+data.substr(5)+'">Cancel</button>'+
                    '</form><!-- /.comment-form -->'+
                  '</div><!-- /.respond -->'
                  );
            
        }
     });


     $(document).on('click','.reply_btn2',function(){
     // $('.reply').click(function(){

        var data=$(this).val();
        var txt=".respondaaa";
        $(txt).remove();
        var tmp1="Post"+data.substr(5);
        var tmp2=$('.submit_comment_child').val();
        if(tmp2==tmp1)
        {

        }
        else
        {
            var divid='#li'+data.substr(5);
            //var divid=".child_comment_list"+data.substr(5);

            $(divid).after('<div class="respond respondaaa respond'+data.substr(5)+'">'+

                    '<h2 class="title">Leave a reply</h2>'+
                    '<form method="post" class="comment_form_child" id="comment_form">'+
                      '<textarea id="comment2" class="form-control comment_box" name="comment" placeholder="Reply*" rows="4" required></textarea>'+
                      '<input type="hidden" name="parentid" value="'+data.substr(5)+'">'+
                      '<input type="hidden" name="videoid" value="<?php echo $video_id; ?>">'+
                      '<button name="submit_comment_child" class="btn submit_btn submit_comment_child" id="submit_comment_child" type="button" value="Post'+data.substr(5)+'">Post</button>'+
                      '<button type="button" name="cancel_comment" class="btn cancel_btn" id="cancel_comment" value="Cancel Comment'+data.substr(5)+'">Cancel</button>'+
                    '</form><!-- /.comment-form -->'+
                  '</div><!-- /.respond -->'
                  );
            
        }
     });

     $(document).on('click','.cancel_btn',function(){
        var val=$(this).val();
        //alert(val);
        var txt=".respond"+val.substr(14);
        //alert(txt);
        $(txt).remove();

     });


     $(document).on('click','.delete_btn',function(e) {
        var data = $(this).val();
        //alert(data);
        $.ajax({
               data: 'commentid='+data,
               type: "post",
               url: "deletecomment.php",
               success: function(response){
                    //alert("sss");
                    if(response=="success"){
                      var divid='#li'+data;
                      var subparentdiv='.lisub'+data;
                      $(subparentdiv).remove();
                      $(divid).remove();
                     }
               }
      });





    });

     $(document).on('click','.update_btn1',function(e) {
        var data = $(this).val();
        //alert(data);
        var idx=data.indexOf('$');
        var commentid=data.slice(0,idx);
        var comment=data.slice(idx+1);

        var txt=".respondaaa";
        $(txt).remove();

        //var divid='#li'+data.substr(5);
        var divid=".child_comment_list"+commentid;


        $(divid).before('<div class="respond respondaaa respond'+commentid+'">'+

                '<h2 class="title">Update Comment</h2>'+
                '<form method="post" class="comment_form_child" id="comment_form">'+
                  '<textarea id="comment2" class="form-control comment_box" name="comment" placeholder="Reply*" rows="4" required>'+comment+'</textarea>'+
                  '<input type="hidden" name="commentid" value="'+commentid+'">'+
                  '<input type="hidden" name="videoid" value="<?php echo $video_id; ?>">'+
                  '<button name="submit_comment_child" class="btn submit_btn update_comment_child" id="submit_comment_child" type="button" value="Update'+commentid
                  +'">Update</button>'+
                  '<button type="button" name="cancel_comment" class="btn cancel_btn" id="cancel_comment" value="Cancel Comment'+commentid+'">Cancel</button>'+
                '</form><!-- /.comment-form -->'+
              '</div><!-- /.respond -->'
              );

      //   $.ajax({
      //          data: 'commentid='+data,
      //          type: "post",
      //          url: "updatecomment.php",
      //          success: function(data){
      //               //alert("sss");
      //          }
      // });

    });

    $(document).on('click','.update_btn2',function(e) {
        var data = $(this).val();
        //alert(data);
        var idx=data.indexOf('$');
        var commentid=data.slice(0,idx);
        var comment=data.slice(idx+1);

        var txt=".respondaaa";
        $(txt).remove();


        var divid='#li'+commentid;
        //var divid=".child_comment_list"+commentid;


        $(divid).after('<div class="respond respondaaa respond'+commentid+'">'+

                '<h2 class="title">Update Comment</h2>'+
                '<form method="post" class="comment_form_child" id="comment_form">'+
                  '<textarea id="comment2" class="form-control comment_box" name="comment" placeholder="" rows="4" required>'+comment+'</textarea>'+
                  '<input type="hidden" name="commentid" value="'+commentid+'">'+
                  '<input type="hidden" name="videoid" value="<?php echo $video_id; ?>">'+
                  '<button name="submit_comment_child" class="btn submit_btn update_comment_child" id="submit_comment_child" type="button" value="Update'+commentid
                  +'">Update</button>'+
                  '<button type="button" name="cancel_comment" class="btn cancel_btn" id="cancel_comment" value="Cancel Comment'+commentid+'">Cancel</button>'+
                '</form><!-- /.comment-form -->'+
              '</div><!-- /.respond -->'
              );

      //   $.ajax({
      //          data: 'commentid='+data,
      //          type: "post",
      //          url: "updatecomment.php",
      //          success: function(data){
      //               //alert("sss");
      //          }
      // });

    });



    $(document).on('click','.update_comment_child',function(e){
      
      var data = $(".comment_form_child").serialize();

      var commentid = $(this).val();
      var txt='.respondaaa';
      $(txt).remove();
      var commentid = commentid.substr(6);
      //alert(data);
      $.ajax({
        data: data,
        type: "post",
        url: "updatecomment.php",
        success: function(res){
          var edit2='.edit'+commentid;
          var txt='.description'+commentid;
          //alert(txt);
          $(txt).text(res);
          $(edit2).text(' (edited) ');
          var update_btn_class='.update_btn_'+commentid;
          $(update_btn_class).val(commentid+'$'+res);
        } 

      });

    });
  $(document).on('click','.user_rating',function(e) {
        var data = $(this).val();
        var rating=data.substr(0,1);
        var videoid=data.substr(1);
        $.ajax({
               data: 'rating='+rating+'&videoid='+videoid,
               type: "post",
               url: "updaterating.php",
               success: function(jobj){
                    //alert("sss");
                     var res=$.parseJSON(jobj);
                     //alert(res['avg_rating']);
                     var fraction_star_index=res['fraction_star_index'];
                     var fraction_star_width=res['fraction_star_width'];
                     fraction_star_width_tmp=fraction_star_width*100-3;
                     $('.rating-num').text(res['avg_rating']);
                     $('.total_cnt').text(res['total_cnt']);
                     $('.part1').css('width',res['part1']+'%');
                     $('.part2').css('width',res['part2']+'%');
                     $('.part3').css('width',res['part3']+'%');
                     $('.part4').css('width',res['part4']+'%');
                     $('.part5').css('width',res['part5']+'%');

                     $('.rating_cnt_part1').text(res['cnt1']);
                     $('.rating_cnt_part2').text(res['cnt2']);
                     $('.rating_cnt_part3').text(res['cnt3']);
                     $('.rating_cnt_part4').text(res['cnt4']);
                     $('.rating_cnt_part5').text(res['cnt5']);

                     $('.rating').html(res['division']);

                     $('.mycss').replaceWith('<div class="mycss"><style type="text/css" scoped>'+
                            '.half {'+
                                'position:relative;'+
                            '}'+
                            '.half:after {'+
                                'content:"";'+
                                'position:absolute;'+
                                'z-index:1;'+
                                'background:#f5f5f5;'+
                                'width: 100%;'+
                                'height: 100%;'+
                                'left: '+fraction_star_width_tmp+'%;'+
                            '}'+
                          '</style></div>');

               }
      });

    });

  $(document).on('click','.like_btn_i',function(e){
    var btn_liked=$("i").hasClass('like_btn_icon1');
    var btn_like_not_clicked=$("i").hasClass('like_btn_icon0');
    var btn_disliked=$("i").hasClass('dislike_btn_icon1');
    var btn_dislike_not_clicked=$("i").hasClass('dislike_btn_icon0');
    // if(btn_disliked==false && btn_dislike_not_clicked==true)
    // {
    //   if(btn_liked==false && btn_like_not_clicked==false)
    //   {

    //   }
    // }
    //alert(btn_liked+' '+btn_like_not_clicked+' '+btn_disliked+' '+btn_dislike_not_clicked);
    var like_cnt=0;
    var dislike_cnt=0;
    if(btn_liked==true)
    {
      $('.like_btn_icon1').removeAttr('style');
      $(this).removeClass('like_btn_icon1');
      $(this).addClass('like_btn_icon0');
      like_cnt=-1;
    }
    else if(btn_disliked==false)
    {
      like_cnt=1;
      
      $(this).removeClass('like_btn_icon0');
      $(this).addClass('like_btn_icon1');
      $('.like_btn_icon1').css('color','blue');
    }
    else if(btn_disliked==true)
    {
      dislike_cnt=-1;
      like_cnt=1;
      $('.dislike_btn_icon1').removeAttr('style');
      $('i').removeClass('dislike_btn_icon1');
      $('i').removeClass('like_btn_icon0');
      $(this).addClass('like_btn_icon1');
      $('.like_btn_icon1').css('color','blue');
    }

    $.ajax({
               data: 'videoid='+<?php echo json_encode($video_id); ?>+'&like_cnt='+like_cnt+'&dislike_cnt='+dislike_cnt,
               type: "post",
               url: "updatelike.php",
               success: function(jobj){
                  // alert(jobj);
                  var res=$.parseJSON(jobj);
                  $('.count_like').text(res['cnt_like']);
                  $('.count_dislike').text(res['cnt_dislike']);
               }
    });

  });

  $(document).on('click','.dislike_btn_i',function(e){
    var btn_liked=$("i").hasClass('like_btn_icon1');
    var btn_like_not_clicked=$("i").hasClass('like_btn_icon0');
    var btn_disliked=$("i").hasClass('dislike_btn_icon1');
    var btn_dislike_not_clicked=$("i").hasClass('dislike_btn_icon0');
    //alert(btn_liked+' '+btn_like_not_clicked+' '+btn_disliked+' '+btn_dislike_not_clicked);

    var like_cnt=0;
    var dislike_cnt=0;
    if(btn_disliked==true)
    {
      dislike_cnt=-1;
      $('.dislike_btn_icon1').removeAttr('style');
      $(this).removeClass('dislike_btn_icon1');
      $(this).addClass('dislike_btn_icon0');
    }
    else if(btn_liked==false)
    {
      dislike_cnt=1;
      
      $(this).removeClass('dislike_btn_icon0');
      $(this).addClass('dislike_btn_icon1');
      $('.dislike_btn_icon1').css('color','blue');
    }
    else if(btn_liked==true)
    {
      dislike_cnt=1;
      like_cnt=-1;
      $('.like_btn_icon1').removeAttr('style');
      $('i').removeClass('like_btn_icon1');
      $('i').removeClass('dislike_btn_icon0');
      
      $(this).addClass('dislike_btn_icon1');
      $('.dislike_btn_icon1').css('color','blue');
    }

    $.ajax({
               data: 'videoid='+<?php echo json_encode($video_id); ?>+'&like_cnt='+like_cnt+'&dislike_cnt='+dislike_cnt,
               type: "post",
               url: "updatelike.php",

               success: function(jobj){
                  var res=$.parseJSON(jobj);

                  $('.count_like').text(res['cnt_like']);
                  $('.count_dislike').text(res['cnt_dislike']);
               }
    });

  });


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
               data: 'authorid='+<?php echo json_encode($authorid1); ?>+'&is_follow='+is_follow,
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