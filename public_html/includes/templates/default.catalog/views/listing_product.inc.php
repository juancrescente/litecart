<?php if ($listing_type == 'column') { ?>
  <div class="col-xs-6 col-sm-4 col-md-3">
    <div class="thumbnail">
      <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
      <div class="caption">
        <h3><?php echo $name; ?></h3>
        <p><?php echo $short_description; ?></p>
        <p>
          <!--<a href="#" class="btn btn-primary">Buy Now!</a>--> <a href="<?php echo htmlspecialchars($link) ?>" class="btn btn-default"><?php echo language::translate('title_more_info', 'More Info'); ?></a>
        </p>
      </div>
    </div>
  </div>
<?php } else if ($listing_type == 'row') { ?>
  <div class="col-md-12">
    <div class="row thumbnail">
      <div class="col-md-3">
        <img class="img-responsive" src="<?php echo hhtmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
      </div>
      <div class="col-md-9 caption">
        <h3><?php echo $name; ?></h3>
        <p><?php echo $short_description; ?></p>
        <p>
          <!--<a href="#" class="btn btn-primary">Buy Now!</a>--> <a href="<?php echo htmlspecialchars($link) ?>" class="btn btn-default"><?php echo language::translate('title_more_info', 'More Info'); ?></a>
        </p>
      </div>
    </div>
  </div>
<?php } else trigger_error('Unknown product listing type definition ('. $listing_type .')', E_USER_WARNING); ?>