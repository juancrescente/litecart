<div class="twelve-eighty">
  <!--snippet:notices-->

  <div class="sidebar">
      <div class="well">
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_search.inc.php'); ?>
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_filter.inc.php'); ?>
        <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
      </div>
    </div>

  <div class="content">
    {snippet:breadcrumbs}

    <div class="category">
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

      <h1><?php echo $h1_title; ?></h1>

      <?php if ($_GET['page'] == 1 && $description) { ?><p class="description"><?php echo $description; ?></p><?php } ?>

      <?php if ($_GET['page'] == 1 && $subcategories) { ?>
      <div class="categories row half-gutter">
        <?php foreach ($subcategories as $subcategory) echo functions::draw_listing_category($subcategory); ?>
      </div>
      <?php } ?>

      <?php if ($products) { ?>
      <div class="products row half-gutter">
        <?php foreach ($products as $product) echo functions::draw_listing_product($product, $product['listing_type']); ?>
      </div>
      <?php } ?>

      <?php echo $pagination; ?>
    </div>
  </div>
</div>