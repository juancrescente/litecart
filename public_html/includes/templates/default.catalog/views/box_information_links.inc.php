<div id="column-left" class="collapse navbar-collapse">
  <div id="box-information-links">
    <h3 class="title"><?php echo language::translate('title_information', 'Information'); ?></h3>
    <div class="content">
      <ul class="nav nav-pills nav-stacked">
        <?php foreach ($pages as $page) { ?>
        <li<?php echo (!empty($page['active']) ? ' class="active"' : ''); ?>><a href="<?php echo htmlspecialchars($page['link']); ?>"><?php echo $page['title']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>