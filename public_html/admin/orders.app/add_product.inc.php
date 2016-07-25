<?php
  document::$layout = 'ajax';

  if (empty($_GET['currency_code'])) $_GET['currency_code'] = settings::get('store_currency_code');
  if (empty($_GET['currency_value'])) $_GET['currency_value'] = currency::$currencies[$_GET['currency_code']]['value'];

  if (!empty($_GET['product_id'])) {
    $product = reference::product($_GET['product_id'], $_GET['currency_code']);
  }
?>
<div class="container-fluid">
  <?php echo functions::form_draw_form_begin('form_add_product', 'post', null, false, 'style="width: 960px;"'); ?>

    <div class="row">
      <div class="form-group col-md-4">
  <?php echo functions::form_draw_products_list('product_id', true, false); ?>

  <?php if (!empty($product)) { ?>
        <div class="thumbnail">
<?php
  list($width, $height) = functions::image_scale_by_width(320, settings::get('product_image_ratio'));
  echo '<img src="'. functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $product->image, $width, $height, settings::get('product_image_clipping')) .'" />';
?>
    </div>
    </div>

      <div class="col-md-8">
        <?php echo functions::form_draw_hidden_field('name', $product->name[$_GET['language_code']]); ?>

<?php
    if (count($product->options) > 0) {
      echo '<div class="row">' . PHP_EOL;

      foreach ($product->options as $group) {

        echo '  <div class="form-group col-md-6">'
           . '    <label>'. $group['name'][$_GET['language_code']] .'</label>';

        switch ($group['function']) {

          case 'checkbox':

            foreach (array_keys($group['values']) as $value_id) {
              $price_adjust_text = '';
              if ($group['values'][$value_id]['price_adjust']) {
                $price_adjust_text = currency::format($group['values'][$value_id]['price_adjust']);
                if ($group['values'][$value_id]['price_adjust'] > 0) {
                  $price_adjust_text = ' +'.$price_adjust_text;
                }
              }

              echo '    <div class="checkbox">' . PHP_EOL
                 . '      <label>' . functions::form_draw_checkbox('options['.$group['name'][$_GET['language_code']].'][]', $group['values'][$value_id]['name'][$_GET['language_code']], true, 'data-group="'. htmlspecialchars($group['name'][$_GET['language_code']]) .'"'. (!empty($group['required']) ? ' required="required"' : '')) .' '. $group['values'][$value_id]['name'][$_GET['language_code']] . $price_adjust_text . '</label>'. PHP_EOL
                 . '    </div>' . PHP_EOL;
            }
            break;

          case 'input':
            $keys = array_keys($group['values']);
            $value_id = array_shift($keys);

            $price_adjust_text = '';
            if ($group['values'][$value_id]['price_adjust']) {
              $price_adjust_text = currency::format($group['values'][$value_id]['price_adjust']);
              if ($group['values'][$value_id]['price_adjust'] > 0) {
                $price_adjust_text = ' +'.$price_adjust_text;
              }
            }

            echo '    ' . functions::form_draw_text_field('options['.$group['name'][$_GET['language_code']].']', true, 'data-group="'. htmlspecialchars($group['name'][$_GET['language_code']]) .'"'. (!empty($group['required']) ? ' required="required"' : '')) . $price_adjust_text . PHP_EOL;
            break;

          case 'radio':

            foreach (array_keys($group['values']) as $value_id) {
              $price_adjust_text = '';
              if ($group['values'][$value_id]['price_adjust']) {
                $price_adjust_text = currency::format($group['values'][$value_id]['price_adjust']);
                if ($group['values'][$value_id]['price_adjust'] > 0) {
                  $price_adjust_text = ' +'.$price_adjust_text;
                }
              }

              echo '    <div class="checkbox">' . PHP_EOL
                 . '      <label>' . functions::form_draw_radio_button('options['.$group['name'][$_GET['language_code']].']', $group['values'][$value_id]['name'][$_GET['language_code']], true, 'data-group="'. htmlspecialchars($group['name'][$_GET['language_code']]) .'"'. (!empty($group['required']) ? ' required="required"' : '')) .' '. $group['values'][$value_id]['name'][$_GET['language_code']] . $price_adjust_text . '</label>' . PHP_EOL
                 . '    </div>' . PHP_EOL;
            }
            break;

          case 'select':

            $options = array(array('-- '. language::translate('title_select', 'Select') .' --', ''));
            foreach (array_keys($group['values']) as $value_id) {

              $price_adjust_text = '';
              if ($group['values'][$value_id]['price_adjust']) {
                $price_adjust_text = currency::format($group['values'][$value_id]['price_adjust']);
                if ($group['values'][$value_id]['price_adjust'] > 0) {
                  $price_adjust_text = ' +'.$price_adjust_text;
                }
              }

              $options[] = array($group['values'][$value_id]['name'][$_GET['language_code']] . $price_adjust_text, $group['values'][$value_id]['name'][$_GET['language_code']]);
            }
            echo '    ' . functions::form_draw_select_field('options['.$group['name'][$_GET['language_code']].']', $options, true, false, 'data-group="'. htmlspecialchars($group['name'][$_GET['language_code']]) .'"'. (!empty($group['required']) ? ' required="required"' : ''));
            break;

          case 'textarea':

            $value_id = array_shift(array_keys($group['values']));
            $price_adjust_text = '';
            if (!empty($group['values'][$value_id]['price_adjust'])) {
              $price_adjust_text = '';
              if ($group['values'][$value_id]['price_adjust'] > 0) {
                $price_adjust_text = ' <br />+'. currency::format($group['values'][$value_id]['price_adjust']);
              }
            }

            echo '    ' . functions::form_draw_textarea('options['.$group['name'][$_GET['language_code']].']', true, 'data-group="'. htmlspecialchars($group['name'][$_GET['language_code']]) .'"'. (!empty($group['required']) ? ' required="required"' : '')) . $price_adjust_text. PHP_EOL;
            break;
        }

        echo '</div>';
      }

      echo '</div>';
    }

    echo functions::form_draw_hidden_field('option_stock_combination', '');
?>

        <div class="row">
          <div class="form-group col-md-6">
            <label><?php echo language::translate('title_price', 'Price'); ?></label>
            <div>
              <?php echo functions::form_draw_hidden_field('price', $price = !empty($product->campaign['price']) ? $product->campaign['price'] : $product->price); ?>
              <?php echo !empty($product->campaign['price']) ? '<del>'. currency::format($product->price, true, false, $_GET['currency_code'], $_GET['currency_value']) .'</del>' : null; ?>
              <?php echo currency::format($price, true, false, $_GET['currency_code'], $_GET['currency_value']); ?>
            </div>
          </div>

          <div class="form-group col-md-6">
            <label><?php echo language::translate('title_tax', 'Tax'); ?></label>
            <div>
              <?php echo functions::form_draw_hidden_field('tax', $tax = tax::get_tax($price, $product->tax_class_id, $_GET['customer'])); ?>
              <?php echo !empty($product->campaign['price']) ? '<del>'. currency::format($tax, true, false, $_GET['currency_code'], $_GET['currency_value']) .'</del>' : null; ?>
              <?php echo currency::format(tax::get_tax(!empty($product->campaign['price']) ? $product->campaign['price'] : $product->price, $product->tax_class_id, $_GET['customer']), true, false, $_GET['currency_code'], $_GET['currency_value']); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
      <label><?php echo language::translate('title_sku', 'SKU'); ?></label>
            <div><?php echo functions::form_draw_hidden_field('sku', $product->sku); ?><?php echo $product->sku ? $product->sku : '-'; ?></div>
    </div>

          <div class="form-group col-md-6">
      <label><?php echo language::translate('title_weight', 'Weight'); ?></label>
            <div><?php echo functions::form_draw_hidden_field('weight', $product->weight) . functions::form_draw_hidden_field('weight_class', $product->weight_class); ?><?php echo weight::format($product->weight, $product->weight_class); ?></div>
          </div>
    </div>

        <div class="row">
          <div class="form-group col-md-6">
      <label><?php echo language::translate('title_quantity', 'Quantity'); ?></label>
            <div><?php echo functions::form_draw_decimal_field('quantity', !empty($_POST['quantity']) ? true : '1', 2); ?></div>
          </div>
    </div>

        <?php if (!empty($product->options_stock)) {?>
        <div class="row">
          <div class="form-group col-md-12">
          <label><?php echo language::translate('title_stock_options', 'Stock Options'); ?></label>
          <table class="table table-default table-striped data-table">
            <tbody>
              <tr>
                <td><strong><?php echo language::translate('title_total', 'Total'); ?></strong></td>
                <td><strong><?php echo (float)$product->quantity; ?></strong></td>
              </tr>
              <?php foreach (array_keys($product->options_stock) as $key) { ?>
              <tr>
                <td><?php echo $product->options_stock[$key]['name'][$_GET['language_code']]; ?></td>
                <td><?php echo (float)$product->options_stock[$key]['quantity']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php } ?>
          </div>
        </div>

        <p><?php echo functions::form_draw_button('add', language::translate('title_add', 'Add'), 'submit', 'class="btn btn-success btn-block"'); ?></p>

      <?php } ?>

      <?php echo functions::form_draw_form_end(); ?>
    </div>
  </div>
</div>

<script>
  $('select[name="product_id"]').change(function(){
    var url = '<?php echo document::ilink(null, array('product_id' => 'selected_product_id'), true); ?>';
    url = url.replace(/selected_product_id/, $(this).val());
    $('.ekko-lightbox.modal.in').modal('hide');
    $('<a href="'+ url +'" data-title="<?php echo functions::general_escape_js(language::translate('title_add_product', 'Add Product')); ?>" />').ekkoLightbox();
  });

  $('button[name="add"]').unbind('click').click(function(e){
    e.preventDefault();

    var item = {
      id: '',
      product_id: $('select[name="product_id"]').val(),
      option_stock_combination: $('input[name="option_stock_combination"]').val(),
      options: {},
      name: $('input[name="name"]').val(),
      sku: $('input[name="sku"]').val(),
      weight: $('input[name="weight"]').val(),
      weight_class: $('input[name="weight_class"]').val(),
      quantity: $('input[name="quantity"]').val(),
      price: $('input[name="price"]').val(),
      tax: $('input[name="tax"]').val()
    };

    $('input[name^="options["][type="radio"]').each(function(){
      if ($(this).is(':checked')) {
        var key = $(this).data('group');
        item.options[key] = $(this).val();
      }
    });

    $('input[name^="options["][type="text"], textarea[name^="options["], select[name^="options["]').each(function(){
      if ($(this).val()) {
        var key = $(this).data('group');
        item.options[key] = $(this).val();
      }
    });

    var option_i = 0;
    $('input[name^="options["][type="checkbox"]').each(function(){
      if ($(this).is(':checked')) {
        var key = $(this).data('group');
        if (!item.options[key]) item.options[key] = [];
        item.options[key][option_i] = $(this).val();
        option_i++;
      }
    });

    addItem(item);
    $('.ekko-lightbox.modal.in').modal('hide');
  });
</script>