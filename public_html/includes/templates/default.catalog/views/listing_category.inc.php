<div class="category category-<?php echo $category_id; ?> col-xs-12 col-sm-6">
  <a href="<?php echo htmlspecialchars($link); ?>">
    <div class="thumbnail">
      <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" alt="" title="<?php echo htmlspecialchars($name); ?>" />
      <div class="caption">
        <h4><?php echo $name; ?></h4>
        <p><?php echo $short_description; ?></p>
      </div>
    </div>
  </a>
</div>
