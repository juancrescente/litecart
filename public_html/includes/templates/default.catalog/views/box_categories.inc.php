<div id="box-categories">
  <h3><?php echo language::translate('title_categories', 'Categories'); ?></h3>
  <div class="categories row">
    <?php foreach ($categories as $category) echo functions::draw_listing_category($category); ?>
  </div>
</div>