<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand visible-xs" href="<?php echo document::ilink(''); ?>">
      <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="margin: -0.5em; max-height: 2em;" />
    </a>
  </div>

  <div id="navbar" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="home hidden-xs">
        <a href="<?php echo document::ilink(''); ?>"><?php echo functions::draw_fonticon('fa-home'); ?></a>
      </li>
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

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php echo functions::draw_fonticon('fa-user'); ?> <?php echo !empty(customer::$data['id']) ? (!empty(customer::$data['firstname']) ? customer::$data['firstname'] : language::translate('title_account', 'Account')) : language::translate('title_sign_in', 'Sign In'); ?>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <?php if (empty(customer::$data['id'])) { ?>
          <li>
            <?php echo functions::form_draw_form_begin('login_form', 'post', document::ilink('login', array('redirect_url' => document::ilink())), false, 'style="width: 320px; margin: 0.5em;"'); ?>
              <div class="form-group">
                <?php echo functions::form_draw_email_field('email', true, 'placeholder="'. htmlspecialchars(language::translate('title_email_address', 'E-mail Address')) .'"'); ?>
              </div>

              <div class="form-group">
                <?php echo functions::form_draw_password_field('password', '', 'placeholder="'. htmlspecialchars(language::translate('title_password', 'Password')) .'"'); ?>
              </div>

              <button name="login" type="submit" class="btn btn-default btn-block"><?php echo language::translate('title_sign_in', 'Sign In'); ?></button>
            <?php echo functions::form_draw_form_end(); ?>
          </li>
          <li role="separator" class="divider"></li>
          <li><a href="<?php echo document::ilink('create_account'); ?>"><?php echo language::translate('title_create_account', 'Create Account'); ?></a></li>
          <?php } else { ?>
          <li><a href="<?php echo document::ilink('edit_account'); ?>"><?php echo language::translate('title_edit_account', 'Edit Account'); ?></a></li>
          <li><a href="<?php echo document::ilink('order_history'); ?>"><?php echo language::translate('title_order_history', 'Order History'); ?></a></li>
          <li role="separator" class="divider"></li>
          <li><a class="btn btn-default btn-block" href="<?php echo document::ilink('logout'); ?>"><?php echo language::translate('title_sign_out', 'Sign Out'); ?></a></li>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </div>
</nav>