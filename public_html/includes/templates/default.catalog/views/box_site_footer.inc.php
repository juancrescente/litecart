<hr style="clear: both;" />

<footer id="footer">
  <div class="panel panel-default panel-body">
    <div class="row">
<!--
      <div class="categories col-xs-6 hidden-xs col-md-2">
        <h4><?php echo language::translate('title_categories', 'Categories'); ?></h4>
        <ul class="list-unstyled">
          <?php foreach ($categories as $category) echo '<li><a href="'. htmlspecialchars($category['link']) .'">'. $category['name'] .'</a></li>' . PHP_EOL; ?>
        </ul>
      </div>

      <?php if ($manufacturers) { ?>
      <div class="manufacturers col-xs-6 hidden-xs col-md-2">
        <h4><?php echo language::translate('title_manufacturers', 'Manufacturers'); ?></h4>
        <ul class="list-unstyled">
        <?php foreach ($manufacturers as $manufacturer) echo '<li><a href="'. htmlspecialchars($manufacturer['link']) .'">'. $manufacturer['name'] .'</a></li>' . PHP_EOL; ?>
        </ul>
      </div>
      <?php } ?>
-->
      <div class="account col-xs-6 col-sm-3 col-md-2">
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

      <div class="information col-xs-6 col-sm-3 col-md-2">
        <h4><?php echo language::translate('title_information', 'Information'); ?></h4>
        <ul class="list-unstyled">
          <?php foreach ($pages as $page) echo '<li><a href="'. htmlspecialchars($page['link']) .'">'. $page['title'] .'</a></li>' . PHP_EOL; ?>
        </ul>
      </div>

      <div class="row col-xs-12 col-sm-6 col-md-8">
        <div class="contact col-xs-12 col-sm-6 col-md-8">
      Lorem ipsum dolor sit amet, populo propriae mei no. Vix tale nonumy id, quis eruditi alienum has at, eu quo utinam possit. Omnis blandit rationibus mel ut, at sit homero ornatus, his choro affert accusam an. Eum ad dolore ignota tractatos. Probo nobis vix at, nam no audiam imperdiet, ius facete singulis accommodare id. No quis meliore disputationi has, in exerci ocurreret mel, mea purto congue id.
      </div>

        <div class="contact col-xs-12 col-sm-6 col-md-4">
        <h4><?php echo language::translate('title_contact', 'Contact'); ?></h4>
        <p><?php echo nl2br(settings::get('store_postal_address')); ?></p><br />
        <p><?php echo settings::get('store_phone'); ?><br />
          <?php list($account, $domain) = explode('@', settings::get('store_email')); echo "<script>document.write('<a href=\"mailto:". $account ."' + '@' + '". $domain ."\">". $account ."' + '@' + '". $domain ."</a>');</script>"; ?></p>
      </div>
      </div>
    </div>

    <h4 class="social-bookmarks text-center" style="margin: 1em 0;">
      <a class="twitter" href="<?php echo document::href_link('http://twitter.com/home/', array('status' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Twitter'); ?>"><?php echo functions::draw_fonticon('fa-twitter-square fa-lg', 'style="color: #55acee;"'); ?></a>
      <a class="facebook" href="<?php echo document::href_link('http://www.facebook.com/sharer.php', array('u' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Facebook'); ?>"><?php echo functions::draw_fonticon('fa-facebook-square fa-lg', 'style="color: #3b5998;"'); ?></a>
      <a class="googleplus" href="<?php echo document::href_link('https://plus.google.com/share', array('url' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Google+'); ?>"><?php echo functions::draw_fonticon('fa-google-plus-square fa-lg', 'style="color: #dd4b39;"'); ?></a>
      <a class="pinterest" href="<?php echo document::href_link('http://pinterest.com/pin/create/button/', array('url' => document::link(''))); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Pinterest'); ?>"><?php echo functions::draw_fonticon('fa-pinterest-square fa-lg', 'style="color: #bd081c;"'); ?></a>
    </h4>
  </div>

  <!-- LiteCart is provided free. Removing the link back to LiteCart.net without written permission is a violation. -->
  <p class="text-center">Copyright &copy; <?php echo date('Y'); ?> <?php echo settings::get('store_name'); ?> &middot; Powered by <a href="http://www.litecart.net" target="_blank">LiteCart</a><sup>®</sup></p>
</footer>