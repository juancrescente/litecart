<?php if ($listing_type == 'column') { ?>
  <div class="product col-xxs-12 col-xs-6 col-sm-4 col-md-4 col-lg-3">
    <div class="thumbnail curved-shadow">
      <a href="<?php echo htmlspecialchars($link) ?>" data-toggle="lightbox" data-gallery="listing" title="<?php echo htmlspecialchars($name); ?>">
        <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="<?php echo htmlspecialchars($name); ?>" />
        <div class="caption">
          <h4 class="name no-padding"><?php echo $name; ?></h4>
          <div class="manufacturer"><?php echo !empty($manufacturer['id']) ? $manufacturer['name'] : '&nbsp;'; ?></div>
          <div class="price-wrapper">
            <?php if ($campaign_price) { ?>
            <del class="regular-price"><?php echo $price; ?></del> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
            <?php } else { ?>
            <span class="price"><?php echo $price; ?></span>
            <?php } ?>
          </div>
        </div>
      </a>
      <?php echo $sticker; ?>
    </div>
  </div>
<?php } else if ($listing_type == 'row') { ?>
  <div class="product col-md-12">
    <div class="row thumbnail curved-shadow">
      <a href="<?php echo htmlspecialchars($link) ?>" data-toggle="lightbox" data-gallery="listing" title="<?php echo htmlspecialchars($name); ?>">
        <div class="col-md-3">
          <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="<?php echo htmlspecialchars($name); ?>" />
        </div>
        <div class="col-md-9 caption">
          <h4 class="name"><?php echo $name; ?></h4>
          <h5 class="manufacturer"><?php echo !empty($manufacturer['id']) ? $manufacturer['name'] : '&nbsp;'; ?></h5>
          <?php echo !empty($short_description) ? '<p>'.$short_description.'</p>' : ''; ?>
          <div class="price-wrapper">
            <?php if ($campaign_price) { ?>
            <del class="regular-price"><?php echo $price; ?></del> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
            <?php } else { ?>
            <span class="price"><?php echo $price; ?></span>
            <?php } ?>
          </div>
        </div>
        <div class="clearfix"></div>
      </a>
    </div>
  </div>
<?php } else trigger_error('Unknown product listing type definition ('. $listing_type .')', E_USER_WARNING); ?>