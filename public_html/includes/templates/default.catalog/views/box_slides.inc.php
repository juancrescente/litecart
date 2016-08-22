<div id="slides" class="carousel slide curved-shadow" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php foreach (array_values($slides) as $key => $slide) { ?>
    <li data-target="#box-slider" data-slide-to="<?php echo $key; ?>"<?php if ($key == 0) echo ' class="active"' ?>></li>
    <?php } ?>
  </ol>

  <div class="carousel-inner" role="listbox">
    <?php foreach (array_values($slides) as $key => $slide) { ?>
    <div class="item<?php if ($key == 0) echo ' active' ?>">
      <?php if (!empty($slide['link'])) echo '<a href="'. htmlspecialchars($slide['link']) .'">'; ?>
      <img src="<?php echo htmlspecialchars($slide['image']); ?>" alt="" />
      <?php echo '</a>'; ?>
      <?php if (!empty($slide['caption'])) { ?>
      <div class="carousel-caption">
        <?php echo $slide['caption']; ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>

  <a class="left carousel-control" href="#box-slider" role="button" data-slide="prev">
    <?php echo functions::draw_fonticon('fa-chevron-left fa-2x previous', 'aria-hidden="true"'); ?>
    <span class="sr-only"><?php language::translate('title_previous', 'Previous'); ?></span>
  </a>
  <a class="right carousel-control" href="#box-slider" role="button" data-slide="next">
    <?php echo functions::draw_fonticon('fa-chevron-right fa-2x next', 'aria-hidden="true"'); ?>
    <span class="sr-only"><?php language::translate('title_next', 'Next'); ?></span>
  </a>
</div>