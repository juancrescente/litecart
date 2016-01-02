<div id="contact-us">
  <h1><?php echo language::translate('title_contact_us', 'Contact Us'); ?></h1>

  <?php echo functions::form_draw_form_begin('contact_form', 'post', false, false, 'style="max-width: 640px;"'); ?>
    
    <div class="row">
      <div class="form-group col-sm-6">
        <label><?php echo language::translate('title_name', 'Name'); ?></label>
        <?php echo functions::form_draw_text_field('name', true, 'required="required"'); ?>
      </div>
      
      <div class="form-group col-sm-6">
        <label><?php echo language::translate('title_email_address', 'Email Address'); ?></label>
        <?php echo functions::form_draw_email_field('email', true, 'required="required"'); ?>
      </div>
    </div>
    
    <div class="row">
      <div class="form-group col-sm-12">
        <label><?php echo language::translate('title_subject', 'Subject'); ?></label>
        <?php echo functions::form_draw_text_field('subject', true, 'required="required"'); ?>
      </div>
    </div>
    
    <div class="row">
      <div class="form-group col-sm-12">
        <label><?php echo language::translate('title_message', 'Message'); ?></label>
          <?php echo functions::form_draw_textarea('message', true, 'required="required" style="height: 250px;"'); ?>
      </div>
    </div>
    
    <div class="row">
      <?php if (settings::get('captcha_enabled')) { ?>
      <div class="form-group col-sm-6">
        <label><?php echo language::translate('title_captcha', 'CAPTCHA'); ?></label>
        <div class="input-group">
          <span class="input-group-addon"><?php echo functions::captcha_generate(100, 40, 4, 'contact_us', 'numbers', 'align="absbottom"'); ?></span>
          <?php echo functions::form_draw_text_field('captcha', '', 'required="required" style="width: 120px; height: 60px; font-size: 24px; text-align: center;"'); ?>
        </div>
      </div>
      <?php } ?>
    </div>
    
    <?php echo functions::form_draw_button('send', language::translate('title_send', 'Send'), 'submit'); ?>
    
  <?php echo functions::form_draw_form_end(); ?>
</div>