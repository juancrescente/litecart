<?php if (!empty($system->customer->data['id'])) return; ?>
<div class="box">
  <div class="heading"><h3><?php echo $system->language->translate('title_login', 'Login'); ?></h3></div>
  <div class="content">
    <?php echo $system->functions->form_draw_form_begin('login_form', 'post'); ?>
      <table style="width: 100%;">
        <tr>
          <td><?php echo $system->language->translate('title_email_address', 'E-mail Address'); ?><br />
            <?php echo $system->functions->form_draw_input_field('email', isset($_POST['email']) ? $_POST['email'] : '', 'text', 'style="width: 175px;"'); ?></td>
        </tr>
        <tr>
          <td><?php echo $system->language->translate('title_password', 'Password'); ?><br />
          <?php echo $system->functions->form_draw_input_field('password', '', 'password', 'style="width: 175px;"'); ?></td>
        </tr>
        <tr>
          <td><?php echo $system->functions->form_draw_button('login', $system->language->translate('title_login', 'Login')); ?> <?php echo $system->functions->form_draw_button('lost_password', $system->language->translate('title_lost_password', 'Lost Password')); ?> </td>
        </tr>
        <tr>
          <td><a href="<?php echo $system->document->href_link(WS_DIR_HTTP_HOME . 'create_account.php'); ?>"><?php echo $system->language->translate('text_new_customers_click_here', 'New customers click here'); ?></a></td>
        </tr>
    </table>
    <?php echo $system->functions->form_draw_form_end(); ?>
  </div>
</div>