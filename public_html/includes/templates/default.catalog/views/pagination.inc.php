<ul class="pagination">
  <?php foreach($items as $item) { ?>
    <?php if ($item['disabled']) { ?>
    <li><span class="disabled"><?php echo $item['title']; ?></span></li>
    <?php } else { ?>
    <li><a class="<?php if ($item['active']) echo ' active'; ?>" href="<?php echo htmlspecialchars($item['link']); ?>"><?php echo $item['title']; ?></a></li>
    <?php } ?>
  <?php } ?>
</ul>
