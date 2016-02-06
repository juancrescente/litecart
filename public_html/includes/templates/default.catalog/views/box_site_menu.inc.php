  <nav class="navbar navbar-default navbar-fixed-top shadow" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo document::ilink(''); ?>" style="margin-top: -0.5em;">
          <img class="img-responsive" src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-height: 2em;" />
        </a>
      </div>
      
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <?php foreach ($items as $item) { ?>
          <li class="<?php echo $item['type'] .'-'. $item['id']; ?><?php echo !empty($item['subitems']) ? ' dropdown' : ''; ?>">
            <a href="<?php echo htmlspecialchars($item['link']); ?>"<?php echo !empty($item['subitems']) ? ' class="dropdown-toggle" data-toggle="dropdown"' : ''; ?>><?php echo $item['title']; ?><?php echo !empty($item['subitems']) ? ' <span class="caret"></span>' : ''; ?></a>
            <?php if (!empty($item['subitems'])) { ?>
            <ul class="dropdown-menu">
              <?php foreach ($item['subitems'] as $subitem) { ?>
              <li class="<?php echo $subitem['type'] .'-'. $subitem['id']; ?>">
                <a href="<?php echo htmlspecialchars($subitem['link']); ?>"><?php echo $subitem['title']; ?></a>
              </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>
          <?php } ?>
        </ul>

        <ul class="nav navbar-nav pull-right">
          <li>
            <div id="cart" class="form-inline" style="margin-top: 0.5em; box-sizing: border-box;">
              <img src="/litecart/includes/templates/default.catalog/images/cart_filled.png" height="32" alt="" class="" />
              <div class="btn-group">
                <a class="btn btn-default" href="<?php echo document::href_ilink('checkout'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo language::translate('title_go_to_checkout', 'Go to checkout'); ?>">
                  <?php echo functions::draw_fonticon('fa-shopping-cart'); ?>
                  
                </a>
                <?php //include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
                <div class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
                  <span class="pull-right" style="margin-left: 1em;"><i class="fa fa-caret-down"></i></span>
                  <span class="quantity"><?php echo cart::$total['items']; ?></span> item(s)
                </div>
                <ul class="items dropdown-menu" role="menu">
                  <?php foreach(cart::$items as $item) { ?>
                  <li>
                    <a href="<?php echo document::href_link('product', array('product_id' => $item['product_id'])); ?>">
                      <?php echo (float)$item['quantity']; ?> x <?php echo $item['name']; ?> - <?php echo currency::format($item['price']); ?>
                    </a>
                  </li>
                  <?php } ?>
                  <li class="divider"></li>
                  <li><a href="<?php echo document::href_ilink('checkout'); ?>"><?php echo language::translate('title_total'); ?>: <span class="formatted-value">$957.92</a></li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>