<div id="cart" class="form-inline" style="margin-top: 0.5em; box-sizing: border-box;">

  <div class="btn-group">
    <a class="btn btn-default" href="<?php echo document::href_ilink('checkout'); ?>" data-placement="bottom" title="<?php echo language::translate('title_go_to_checkout', 'Go to checkout'); ?>">
      <?php //echo functions::draw_fonticon('fa-shopping-cart'); ?>
      <img src="<?php echo WS_DIR_TEMPLATE; ?>images/cart.png" height="32" alt="" class="" />
      <span class="quantity"><?php echo cart::$total['items']; ?></span> <?php echo language::translate('title_items_s', 'Item(s)'); ?>
    </a>
    <?php //include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
    <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-caret-down"></i>
    </div>
    <ul class="items dropdown-menu">
      <?php foreach(cart::$items as $item) { ?>
      <li>
        <a href="<?php echo document::href_link('product', array('product_id' => $item['product_id'])); ?>">
          <?php echo (float)$item['quantity']; ?> x <?php echo $item['name']; ?> - <?php echo currency::format($item['price']); ?>
        </a>
      </li>
      <?php } ?>
      <li class="divider"></li>
      <li><a href="<?php echo document::href_ilink('checkout'); ?>"><?php echo language::translate('title_total'); ?>: <span class="formatted-value"><?php echo currency::format(cart::$total['value']); ?></a></li>
    </ul>
  </div>
</div>