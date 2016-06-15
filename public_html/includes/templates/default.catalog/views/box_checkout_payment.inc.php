<div id="checkout-payment">
  <h2><?php echo language::translate('title_payment', 'Payment'); ?></h2>

  <div class="options btn-group-vertical btn-block">
    <?php foreach ($options as $module) foreach ($module['options'] as $option) { ?>
    <?php echo functions::form_draw_radio_button('payment_option', $module['id'].':'.$option['id'], $selected['id'], 'style="display: none;"'); ?>
    <div class="option btn btn-default <?php echo ($module['id'].':'.$option['id'] == $selected['id']) ? 'active' : ''; ?>">
    <?php echo functions::form_draw_form_begin('payment_form', 'post') . functions::form_draw_hidden_field('selected_payment', $module['id'].':'.$option['id'], $selected['id']); ?>
      <div class="header row" style="margin: 0;">
        <div class="col-md-3 thumbnail" style="margin: 0;">
          <img src="<?php echo functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_HTTP_HOME . $option['icon'], 125, 50, 'FIT_ONLY_BIGGER_USE_WHITESPACING'); ?>" />
        </div>
        <div class="col-md-5 text-left">
          <h4 class="title" style="margin: 0.5em 0 0 0;"><?php echo $module['title']; ?></h4>
          <div class="name"><?php echo $option['name']; ?></div>
        </div>
        <div class="col-md-4 text-right">
          <div class="price"><?php echo ($option['cost'] != 0) ? '+ ' . currency::format(tax::get_price($option['cost'], $option['tax_class_id'])) : ''; ?></div>
        </div>
      </div>

      <?php if (!empty($option['description']) || !empty($option['fields'])) { ?>
      <div class="content">
        <hr />
        <p class="description text-left"><?php echo $option['fields'] . $option['description']; ?></p>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>

<style>
#checkout-payment .option .content {
  -webkit-transition: all 0.25s ease;
  -moz-transition: all 0.25s ease;
  -o-transition: all 0.25s ease;
  transition: all 0.25s ease;
  max-height: 200px;
  overflow-y: auto;
}
#checkout-payment .option:not(.active) {
  opacity: 0.75;
  -webkit-transition: all 0.25s ease;
  -moz-transition: all 0.25s ease;
  -o-transition: all 0.25s ease;
  transition: all 0.25s ease;
}
#checkout-payment .option:not(.active) .content {
  max-height: 0;
  overflow-y: hidden;
}
</style>