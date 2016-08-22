<div class="navbar">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle navbar-toggle-default pull-left collapsed" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="navbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div id="search">
      <?php echo functions::form_draw_form_begin('search_form', 'get', document::ilink('search')); ?>
        <div class="input-group">
          <?php echo functions::form_draw_search_field('query', true, 'placeholder="'. language::translate('text_search_products', 'Search products') .'&hellip;"'); ?>
          <div class="input-group-btn">
              <button class="btn btn-default" type="submit"><?php echo functions::draw_fonticon('fa-search'); ?></button>
          </div>
        </div>
      <?php echo functions::form_draw_form_end(); ?>
    </div>
  </div>

  <div id="sidebar" class="collapse navbar-collapse">
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_filter.inc.php'); ?>
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
  </div>
</div>