<div class="container">

  <div class="rows">
    <div class="col-md-3">
      <div class="sidebar">
        <?php include(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
      </div>
    
    </div>
    
    <div class="col-md-9">
      {snippet:breadcrumbs}
      
      <div id="box-manufacturer" class="box">
        <div class="btn-group pull-right">
<?php
  $separator = false;
  foreach ($sort_alternatives as $key => $value) {
    if ($separator) echo ' ';
    if ($_GET['sort'] == $key) {
      echo '<span class="btn btn-default active">'. $value .'</span>';
    } else {
      echo '<a class="btn btn-default" href="'. document::href_ilink(null, array('sort' => $key), true) .'">'. $value .'</a>';
    }
    $separator = true;
  }
?>
        </div>
        
        <h1 class="title"><?php echo $title; ?></h1>
        
        <div class="content">
        
          <?php if ($_GET['page'] == 1 && $description) { ?>
          <div class="description-wrapper">
            <p class="manufacturer-description"><?php echo $description; ?></p>
          </div>
          <?php } ?>
          
          <?php if ($products) { ?>
          <ul class="listing-wrapper products">
            <?php foreach ($products as $product) echo functions::draw_listing_product($product, 'column'); ?>
          </ul>
          <?php } ?>
          
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
</div>