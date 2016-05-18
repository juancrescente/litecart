<div id="column-left" class="navbar-collapse">
  <div id="box-information-links">
    <h3 class="title"><?php echo language::translate('title_customer_service', 'Customer Service'); ?></h3>
    <ul class="nav nav-pills nav-stacked">
      <?php foreach ($pages as $page) { ?>
      <li<?php echo (!empty($page['active']) ? ' class="active"' : ''); ?>><a href="<?php echo htmlspecialchars($page['link']); ?>"><?php echo $page['title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</div>