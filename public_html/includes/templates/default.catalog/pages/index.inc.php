<div class="container">
  <div class="row">
    <div class="sidebar col-md-3">
      <div class="well">
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_search.inc.php'); ?>
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
      </div>
    </div>
    
    <div class="col-md-9">
     
      <div id="index">
        <!--snippet:box_slider-->
        
        <!--snippet:box_latest_products-->

        <!--snippet:box_most_popular_products-->

        <!--snippet:box_campaign_products-->
        
        <!--snippet:box_latest_products-->
      </div>
    </div>
  </div>
  
  <hr />
  
  <div class="text-center">
    <!--snippet:box_manufacturer_logotypes-->
  </div>
</div>