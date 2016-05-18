<style>
@media screen and (max-width: 768px) {
  .sidebar {
    position: static !important;
  }
}
#sidebar {
  clear: both;
}
</style>

<div class="navbar">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle navbar-toggle-default pull-left collapsed" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="navbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_search.inc.php'); ?>
  </div>

  <div id="sidebar" class="collapse navbar-collapse">
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
  </div>
</div>