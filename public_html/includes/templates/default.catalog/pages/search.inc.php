<div class="container">
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
    <div class="row products">
      <?php foreach ($products as $product) echo functions::draw_listing_product($product, 'column'); ?>
    </div>
    <?php } ?>
    
    <?php echo $pagination; ?>
  </div>
</div>