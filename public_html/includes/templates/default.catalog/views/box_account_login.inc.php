<div class="">
  <h3><?php echo language::translate('title_login', 'Login'); ?></h3>

  <?php echo functions::form_draw_form_begin('login_form', 'post', document::ilink('login')); ?>
    <?php echo functions::form_draw_hidden_field('redirect_url', !empty($_GET['redirect_url']) ? $_GET['redirect_url'] : document::ilink('')); ?>
    
    <div class="form-group">
      <label><?php echo language::translate('title_email_address', 'Email Address'); ?></label>
      <?php echo functions::form_draw_text_field('email', true, 'required="required" style="width: 190px"'); ?>
    </div>
    
    <div class="form-group">
      <td><?php echo language::translate('title_password', 'Password'); ?><br />
      <?php echo functions::form_draw_password_field('password', '', 'style="width: 190px"'); ?></td>
    </div>
    
    <div class="checkbox">
      <label><?php echo functions::form_draw_checkbox('remember_me', '1', true); ?> <?php echo language::translate('title_remember_me', 'Remember Me'); ?></label>
    </div>
    
    <div class="btn-group" role="group">
      <?php echo functions::form_draw_button('login', language::translate('title_login', 'Login')); ?>
      <?php echo functions::form_draw_button('lost_password', language::translate('title_lost_password', 'Lost Password'), 'submit', 'style="font-size: 0.8em;"'); ?>
    </div>

    <p><a href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('text_new_customers_click_here', 'New customers click here'); ?></a></p>
    
  <?php echo functions::form_draw_form_end(); ?>
</div>