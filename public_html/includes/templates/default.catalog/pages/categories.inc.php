<!--snippet:notices-->

<div id="box-categories">
  <h3><?php echo language::translate('title_categories', 'Categories'); ?></h3>
  <div class="categories row half-gutter">
    <?php foreach ($categories as $category) echo functions::draw_listing_category($category); ?>
  </div>
</div>