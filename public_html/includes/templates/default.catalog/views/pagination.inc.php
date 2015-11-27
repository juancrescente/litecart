<nav>
  <ul class="pagination">
  <?php foreach($items as $item) { ?>
    <?php if ($item['disabled']) ?>
    <li class="disabled<?php if ($item['active']) echo ' active'; ?>"><span><?php echo $item['title']; ?></span></li>
    <?php } else { ?>
    <li class="<?php if ($item['active']) echo ' active'; ?>"><a href="<?php echo htmlspecialchars($item['link']); ?>"><?php echo $item['title']; ?></a></li>
    <?php } ?>
  <?php } ?>
  </ul>
</nav>