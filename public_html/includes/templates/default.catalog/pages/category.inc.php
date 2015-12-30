<div class="container" id="box-category">
  <nav class="pull-right">
<?php
    $separator = false;
    foreach ($sort_alternatives as $key => $value) {
      if ($separator) echo ' ';
      if ($_GET['sort'] == $key) {
        echo '<span class="button active">'. $value .'</span>';
      } else {
        echo '<a class="button" href="'. document::href_ilink(null, array('sort' => $key), true) .'">'. $value .'</a>';
      }
      $separator = true;
    }
?>
  </nav>
  <h1><?php echo $h1_title; ?></h1>

  <?php if ($_GET['page'] == 1) { ?>
  <?php if ($description) { ?><p class="category-description"><?php echo $description; ?></p><?php } ?>

  <?php if ($subcategories) { ?>
  <div class="row">
    <?php foreach ($subcategories as $subcategory) echo functions::draw_listing_category($subcategory); ?>
  </div>
  <?php } ?>
  <?php } ?>
  
  <?php if ($products) { ?>
  <div class="row">
    <?php foreach ($products as $product) echo functions::draw_listing_product($product, $product['listing_type']); ?>
  </div>
  <?php } ?>
  
  <div class="row">
    <?php echo $pagination; ?>
  </div>
</div>