<!--snippet:notices-->

<div class="sidebar">
  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATE . 'views/column_left.inc.php'); ?>
</div>

<div class="content">
  {snippet:breadcrumbs}

  <div id="box-search-results">
    <nav class="filter pull-right">
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
    </nav>

    <h1 class="title"><?php echo $title; ?></h1>

    <?php if ($products) { ?>
    <div class="row products half-gutter">
      <?php foreach ($products as $product) echo functions::draw_listing_product($product, 'column'); ?>
    </div>
    <?php } ?>

    <?php echo $pagination; ?>
  </div>
</div>