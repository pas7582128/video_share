<?php
	include 'header_small.php';
?>

 <?php 

if(isset($_POST['information-form-submit']))
{
  $userid = $_SESSION['id'];

  $city = mysqli_escape_string($con,$_POST['city']);



  $state = mysqli_escape_string($con,$_POST['state']);
  
  $select_state=mysqli_query($con,"SELECT stateName FROM states WHERE stateID='$state'");
  $row_state=mysqli_fetch_assoc($select_state);
  $state=$row_state['stateName'];

  $country = mysqli_escape_string($con,$_POST['country']);
  $pincode = $_POST['pincode'];
  $family_members_count = $_POST['family_members_count'];
  $income_members_count = $_POST['income_members_count'];
  $family_income = $_POST['family_income'];
  $vehicle_count_2wheel = $_POST['vehicle_count_2wheel'];
  $vehicle_count_4wheel = $_POST['vehicle_count_4wheel'];
  $present_address = mysqli_escape_string($con,$_POST['present_address']);
  $permanent_address = mysqli_escape_string($con,$_POST['permanent_address']);

  $query_update = "UPDATE `users` SET `city`='$city',`state`='$state',`country`='$country',`pincode`='$pincode',`family_members_count`='$family_members_count',`income_members_count`='$income_members_count',`family_income`='$family_income',`vehicle_count_2wheel`='$vehicle_count_2wheel',`vehicle_count_4wheel`='$vehicle_count_4wheel',`present_address`='$present_address',`permanent_address`='$permanent_address' WHERE `id`='$userid'";

  $result_update = mysqli_query($con,$query_update);

  if($result_update){
  	echo '<script>alert("Information added Sucessfully");</script>';
  	echo '<script>window.location.href="index.php"</script>';
  }
  else{
  	echo '<script>alert("Something went wrong '.mysqli_error($con).'");</script>';
  	echo '<script>window.location.href="user_information_form.php"</script>';
  }


}


?>

<script>
$(document).ready(function(){

  $("#income_members_count").change(function(){


      var income_members = $("#income_members_count").val();
      var family_members = $("#family_members_count").val();

      if(income_members > family_members){
        $("#income_members_count").val("");
        alert("Number of members of who earns should be less than family members");
      }
  });

});

</script>

<section class="form-elements">
    <div class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-10">
            <div class="left-panel">
              <h2 class="section-title">Information Form</h2><!-- /.section-title -->
              
              <form class="register-form" method="post" enctype="multipart/form-data">
                <p class="form-input">
                  <label for="country">Country</label>                                  
                  <input type="text" class="form-control" name="country" value="India" readonly>  
                </p>

                <p class="form-input">
                  <label for="state">State</label>
                  <select class="form-control" name="state" id="state" required>
                      <?php 
                        $select_country=mysqli_query($con,"SELECT * FROM states WHERE countryID='IND' ORDER BY stateName ASC");
                        while($row=mysqli_fetch_array($select_country))
                        {
                            echo '<option value="'.$row['stateID'].'">'.$row['stateName'].'</option>';
                        }
                      ?>
                  </select>
                </p>
                
                
                <p class="form-input">
                  <label for="city">City</label>
                  <?php

                      

                      $select_city=mysqli_query($con,"SELECT * FROM `cities` WHERE stateID=5243 ORDER BY `cityName` ASC");
                  ?>
                  <select class="form-control" name="city" id="city" required>
                      <?php 
                      
                      while($row=mysqli_fetch_assoc($select_city))
                      {
                        echo '<option value="'.$row['cityName'].'">'.$row['cityName'].'</option>';
                      }


                    ?>
                  </select>
                </p>
                
                <p class="form-input">
                  <label for="pincode">Pincode</label>
                  <input type="text" class="form-control" name="pincode" placeholder="Pincode" pattern="[0-9].{5}" required>
                </p>
                <p class="form-input">
                  <label for="Number of Family Members">Number of Family members</label>
                  <input type="text" class="form-control" name="family_members_count" id="family_members_count" placeholder="Number of Family members" pattern="^[1-9][0-9]*" required>
                </p><br>
                <p class="form-input">
                  <label for="Number of Family Members who earns">Number of Family members who earns</label>
                  <input type="text" class="form-control" name="income_members_count" id="income_members_count" placeholder="Number of Family members who earns" pattern="^[1-9][0-9]*" required>
                </p>
                <p class="form-input">
                  <label for="Total Family Income">Total Family Income</label>
                  <input type="text" class="form-control" name="family_income" placeholder="Total Family Income" pattern="^[1-9][0-9]*" required>
                </p>
                <p class="form-input">
                  <label for="Number of 2 wheeler Vehicle">Number of 2 wheeler Vehicle</label>
                  <input type="text" class="form-control" name="vehicle_count_2wheel" placeholder="Number of 2 wheeler Vehicle" pattern="[0-9]*" required>
                </p>
                <p class="form-input">
                  <label for="Number of 4 wheeler Vehicle">Number of 4 wheeler Vehicle</label>
                  <input type="text" class="form-control" name="vehicle_count_4wheel" placeholder="Number of 4 wheeler Vehicle" pattern="[0-9]*" required>
                </p>
                <p class="form-input">
                  <label for="Present Address">Present Address</label>
                  <textarea type="text" class="form-control" placeholder="Present Address" name="present_address" required></textarea>
                </p>
                <p class="form-input">
                  <label for="Permanent Address">Permanent Address</label>
                  <textarea type="text" class="form-control" placeholder="Permanent Address" name="permanent_address" required></textarea>
                </p>
                <p class="checkbox">
                  <input name="rememberme" type="checkbox" class="rememberme pull-left" value="Remember Me" required /> 
                  I agree the 
                  <a href="#"> terms and conditions</a>
                </p>
                <p class="submit-input">
                  <input type="submit" class="btn" name="information-form-submit" value="Submit Now">
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

<script type="text/javascript">
  $(document).ready(function(){
      $('#state').on('change',function(){
          var stateID=$(this).val();
          if(stateID)
          {
            $.ajax({
              type:'POST',
              url:'getcity.php',
              data:'stateID='+stateID,
              success:function(res)
              {
                  $('#city').html(res);
              }

            });
          }
      });
  });
</script>