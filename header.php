<?php 


$con=mysqli_connect("localhost","root","","video_share"); 
if(!isset($_SESSION))
{
session_start();
}

include 'verify_userstatus.php';


?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="zxx"> <!--<![endif]-->

<!-- Mirrored from demos.jeweltheme.com/videostories/index-01.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 Jun 2019 12:02:05 GMT -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VideoStories</title>
  <meta name="description" content="VideoStories - Video Blogging HTML5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">

  <!-- ========= FontAwesome Icon Css File ========= -->
  <link rel="stylesheet" href="assets/css/themify-icons.css">

  <!-- ========= Themify Icon Css File ========= -->
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">

  <!-- ========= Bootstrap Css File ========= -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- ========= Magnific PopUp Css File ========= -->
  <link rel="stylesheet" href="assets/css/magnific-popup.css">

  <!-- ========= Owl Carousel Css File ========= -->
  <link rel="stylesheet" href="assets/css/owl.carousel.css">

  <!-- ========= Animate Css File ========= -->
  <link rel="stylesheet" href="assets/css/animate.min.css">  

  <!-- ========= Template Default Css File ========= -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- ========= Template Menu Css File ========= -->
  <link rel="stylesheet" href="assets/css/header.css">  

  <!-- ========= Template Main Css File ========= -->
  <link rel="stylesheet" href="assets/css/themes.css">  

  <!-- ========= Template Responsive Style Css File ========= -->
  <link rel="stylesheet" href="assets/css/responsive.css">

  <!-- ========= Search Css File ========= -->  
  <link rel="stylesheet" href="assets/css/mystyle.css">

  <script src="assets/js/modernizr.custom.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- ========= Template Testimonial Style Css File ========= -->
  <link rel="stylesheet" href="assets/css/testimonial.css">
  <link rel="stylesheet" href="assets/css/bootstrap413.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){

    $(".search-input").keyup(function(){
             var str = $(".search-input").val();
            if (str.length==0) {
              document.getElementById("livesearchbox").innerHTML="";
              document.getElementById("livesearchbox").style.border="0px";
              return;
            }
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            } else {  // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
              if (this.readyState==4 && this.status==200) {
                document.getElementById("livesearchbox").innerHTML=this.responseText;
                // alert("aaa");
                $('#livesearchbox').addClass('col-md-12');
                //document.getElementById("livesearchbox").style.width="inherit";
                document.getElementById("livesearchbox").style.border="1px solid #A5ACB2";
              }
            }
            xmlhttp.open("GET","livesearch.php?q="+str,true);
            xmlhttp.send();
                   });
      });
  </script>
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->


</head>



<body>



  <header class="header">
    <div class="header-top">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="top-sitemap text-left">
              <?php
                if(!isset($_SESSION['id'])){
              ?>
              <span> <a href="signin.php"><i class="fa fa-lock"></i> Sign In</a></span>
              <span><a href="register.php"><i class="fa fa-user"></i> Register</a></span>
              <?php 
              } else {
              ?>
              <span>Welcome Back! <?php echo $_SESSION['fname']; ?></span>
              <span> <a href="logout.php"><i class="fa fa-lock"></i> Logout</a></span>
              <?php } ?>
            </div><!-- /.top-sitemap -->
          </div>

          
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.header-top -->

    

    <div class="header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-8">
            <nav class="navbar navbar-default">
              <div class="navbar-header visible-xs">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
                  <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
              </div>

              <div id="menu" class="main-menu collapse navbar-collapse pull-left">

                <ul class="nav navbar-nav">

                  <li class="menu-item active">
                    <a href="index.php">Home</a>
                  </li>

                  <li class="menu-item menu-item-has-children">
                    <a href="#">Categories</a>
                    <ul class="sub-menu children">
                      <?php
                        $select_category=mysqli_query($con,"SELECT * FROM category");
                        while($row_category=mysqli_fetch_array($select_category)){
                        ?>
                      <li><a href="category.php?category_id=<?php echo $row_category['id'] ?>"><?php echo $row_category['category_name'] ?></a></li>
                      <?php } ?>
                    </ul>
                  </li>

                  <!-- <li class="menu-item menu-item-has-children">
                    <a href="#">Pages</a>
                    <ul class="sub-menu children">
                      <li><a href="contact.html">Contact</a></li>
                      <li><a href="register.html">Register</a></li>
                      <li><a href="signup.html">Sign Up</a></li>
                      <li><a href="signin.html">Sign In</a></li>
                    </ul>
                  </li> -->

                  <li class="menu-item">
                    <a href="faq.php">FAQs</a>
                    
                      
                    
                  </li>
<?php
if(isset($_SESSION['id'])){
?>
                  

                  <li class="menu-item menu-item-has-children">
                    <a href="#">My account</a>
                    <ul class="sub-menu children">
                      <li><a href="author.php">Profile</a></li>
                      <li><a href="videos.php">Profile Videos</a></li>
                      <!-- <li><a href="playlist.php">Profile Playlist</a></li> -->
                      <li><a href="upload.php">Submit Video</a></li>
                      <li><a href="about.php">Profile Details</a></li>
                    </ul>
                  </li>
                  <?php } ?>
                </ul>
              </div><!-- /.navbar-collapse -->
            </nav><!-- /.navbar -->
          </div>
          <div class="col-sm-4 col-md-4">
            <form class="search-form">
              <input name="s" type="text" class="search-input" size="20" maxlength="20" placeholder="Search Here ...." required="">
              
              <ul id="livesearchbox" class="result"></ul>
            </form><!-- /.search-form -->
          </div>

        </div>
      </div><!-- /.container -->
    </div><!-- /.header-bottom -->
  </header><!-- /.header -->
