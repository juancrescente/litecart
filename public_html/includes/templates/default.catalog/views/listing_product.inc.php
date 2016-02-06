<?php if ($listing_type == 'column') { ?>
  <div class="product col-xxs-12 col-xs-6 col-sm-4 col-md-3">
    <div class="thumbnail curved-shadow">
      <a href="<?php echo htmlspecialchars($link) ?>" data-toggle="lightbox" data-gallery="listing" title="<?php echo htmlspecialchars($name); ?>">
        <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="<?php echo htmlspecialchars($name); ?>" />
        <div class="caption">
          <h4><?php echo $name; ?></h4>
          <!--<p><?php echo !empty($manufacturer['id']) ? $manufacturer['name'] : '&nbsp;'; ?></p>-->
          <div class="price-wrapper">
            <?php if ($campaign_price) { ?>
            <s class="regular-price"><?php echo $price; ?></s> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
            <?php } else { ?>
            <span class="price"><?php echo $price; ?></span>
            <?php } ?>
          </div>
        </div>
      </a>
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
          <h3><?php echo $name; ?></h3>
          <?php echo !empty($short_description) ? '<p>'.$short_description.'</p>' : ''; ?>
          <div class="price-wrapper">
            <?php if ($campaign_price) { ?>
            <s class="regular-price"><?php echo $price; ?></s> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
            <?php } else { ?>
            <span class="price"><?php echo $price; ?></span>
            <?php } ?>
          </div>
        </div>
      </a>
    </div>
  </div>
<?php } else trigger_error('Unknown product listing type definition ('. $listing_type .')', E_USER_WARNING); ?>