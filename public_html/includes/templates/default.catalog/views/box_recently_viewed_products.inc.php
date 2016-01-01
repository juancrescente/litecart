<div id="box-recently-viewed-products">
  <h3 class="title"><?php echo language::translate('title_recently_viewed', 'Recently Viewed'); ?></h3>
  <ul class="list-group">
    <?php foreach ($products as $product) { ?>
    <li class="list-group-item thumbnail">
      <a href="<?php echo htmlspecialchars($product['link']); ?>">
        <img src="<?php echo htmlspecialchars($product['thumbnail']); ?>" alt="" />
        </a>
      </li>
    <?php } ?>
  </ul>
</div>