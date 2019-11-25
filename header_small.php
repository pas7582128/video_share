<?php 


$con=mysqli_connect("localhost","root","","video_share"); 
if(!isset($_SESSION))
{
session_start();
}
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

  <script src="assets/js/modernizr.custom.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

  <style type="text/css">
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  } 
  </style>


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

          
      </div><!-- /.container -->
    </div><!-- /.header-top -->

    