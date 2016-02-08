<div class="row">
  <div class="col-lg-12">
    <h3><?php echo language::translate('title_most_popular_products', 'Most Popular Products'); ?></h3>
  </div>
</div>

<div class="products row half-gutter text-center">
  <?php foreach($products as $product) echo functions::draw_listing_product($product); ?>
</div>