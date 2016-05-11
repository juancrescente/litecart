<hr style="clear: both;" />

<footer>
  <div class="twelve-eighty">
    <div class="row">

        <div class="categories col-xs-6 col-sm-3 col-md-fifths">
          <h4><?php echo language::translate('title_categories', 'Categories'); ?></h4>
          <ul class="list-unstyled">
            <?php foreach ($categories as $category) echo '<li><a href="'. htmlspecialchars($category['link']) .'">'. $category['name'] .'</a></li>' . PHP_EOL; ?>
          </ul>
        </div>

        <?php if ($manufacturers) { ?>
        <div class="manufacturers col-xs-6 col-sm-3 col-md-fifths">
          <h4><?php echo language::translate('title_manufacturers', 'Manufacturers'); ?></h4>
          <ul class="list-unstyled">
          <?php foreach ($manufacturers as $manufacturer) echo '<li><a href="'. htmlspecialchars($manufacturer['link']) .'">'. $manufacturer['name'] .'</a></li>' . PHP_EOL; ?>
          </ul>
        </div>
        <?php } ?>

        <div class="account col-xs-6 col-sm-3 col-md-fifths">
          <h4><?php echo language::translate('title_account', 'Account'); ?></h4>
          <ul class="list-unstyled">
            <li><a href="<?php echo document::ilink('customer_service'); ?>"><?php echo language::translate('title_customer_service', 'Customer Service'); ?></a></li>
            <li><a href="<?php echo document::href_ilink('regional_settings'); ?>"><?php echo language::translate('title_regional_settings', 'Regional Settings'); ?></a></li>
            <?php if (empty(customer::$data['id'])) { ?>
            <li><a href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('title_create_account', 'Create Account'); ?></a></li>
            <li><a href="<?php echo document::href_ilink('login'); ?>"><?php echo language::translate('title_login', 'Login'); ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo document::href_ilink('order_history'); ?>"><?php echo language::translate('title_order_history', 'Order History'); ?></a></li>
            <li><a href="<?php echo document::href_ilink('edit_account'); ?>"><?php echo language::translate('title_edit_account', 'Edit Account'); ?></a></li>
            <li><a href="<?php echo document::href_ilink('logout'); ?>"><?php echo language::translate('title_logout', 'Logout'); ?></a></li>
            <?php } ?>
          </ul>
        </div>

        <div class="information col-xs-6 col-sm-3 col-md-fifths">
          <h4><?php echo language::translate('title_information', 'Information'); ?></h4>
          <ul class="list-unstyled">
            <?php foreach ($pages as $page) echo '<li><a href="'. htmlspecialchars($page['link']) .'">'. $page['title'] .'</a></li>' . PHP_EOL; ?>
          </ul>
        </div>

        <div class="contact col-xs-12 col-sm-3 col-md-fifths">
          <h4><?php echo language::translate('title_contact', 'Contact'); ?></h4>
          <p><?php echo nl2br(settings::get('store_postal_address')); ?></p><br />
          <p><?php echo settings::get('store_phone'); ?><br />
            <?php list($account, $domain) = explode('@', settings::get('store_email')); echo "<script>document.write('<a href=\"mailto:". $account ."' + '@' + '". $domain ."\">". $account ."' + '@' + '". $domain ."</a>');</script>"; ?></p>
        </div>
      </ul>
    </div>

    <!-- LiteCart is provided free by End-User License Agreement (EULA). Removing the link back to LiteCart.net without written permission is a violation. -->
    <p class="text-center">Copyright &copy; <?php echo date('Y'); ?> <?php echo settings::get('store_name'); ?> &middot; Powered by <a href="http://www.litecart.net" target="_blank">LiteCart</a></p>
  </div>
</footer>