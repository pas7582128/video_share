<?php
  include 'conn.php';
  

$q=$_GET["q"];
$count = "SELECT * from `video` WHERE video_name LIKE '".$q."%'";
    $result = mysqli_query($con,$count);

if (strlen($q)>0) {
  $hint="";
  while($row = mysqli_fetch_array($result)){


      
        if ($hint=="") {
          
          $hint="<li><a href='video.php?video_id=" .
          $row['id'] ."' target='_parent' >".'<b>'.substr($row['video_name'],0,strlen($q)).'</b>'.substr($row['video_name'], strlen($q))."</a></li>";
        } else {
           $hint=$hint."<li><a href='video.php?video_id=" .
          $row['id'] ."' target='_parent' >".'<b>'.substr($row['video_name'],0,strlen($q)).'</b>'.substr($row['video_name'], strlen($q))."</a></li>";
        }
      

  }
}


if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}
// echo "<script>alert("aaa");</script>"
echo $response;
?>
