<div id="widgets">
  <?php foreach ($widgets as $widget) { ?>
  <div id="widget-<?php echo $widget['code']; ?>">
    <?php echo $widget['content']; ?>
  </div>
  <?php } ?>
</div>