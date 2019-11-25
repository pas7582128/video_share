<?php
  include 'verify_userstatus.php';

?>


<div class="col-sm-4">
            <aside class="sidebar">
              

              <div class="widget widget_categories">
              <h3 class="widget-title">Video Categories</h3><!-- /.widget-title -->
                <div class="widget-details">
                  <?php $select_category=mysqli_query($con,"SELECT * FROM category LIMIT 5");
                  while($row_category=mysqli_fetch_array($select_category)){ ?>
                  <a href="category.php?category_id=<?php echo $row_category['id']; ?>"><?php echo $row_category['category_name']; ?></a>
                  <?php } ?>
                </div><!-- /.widget-details -->
              </div>

              

              

            </aside><!-- /.sidebar -->
          </div>