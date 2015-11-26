<nav>
  <ul class="pagination">
  <?php foreach($items as $item) { ?>
    <?php if ($item['disabled']) ?>
    <li class="disabled<?php echo ($item['active']) ? 'active' : ''; ?>"><span><?php echo $item['title']; ?></span></li>
    <?php } else { ?>
    <li class="<?php echo ($item['active']) ? 'active' : ''; ?>"><a href="<?php echo htmlspecialchars($item['link']); ?>"><?php echo $item['title']; ?></a></li>
    <?php }
  <?php } ?>
  </ul>
</nav>