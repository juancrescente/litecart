<?php

  if (!empty($_GET['order_id'])) {
    $order = new ctrl_order($_GET['order_id']);
  } else {
    $order = new ctrl_order();
  }

  if (empty($_POST)) {

    foreach ($order->data as $key => $value) {
      $_POST[$key] = $value;
    }

  // Convert to local currency
    foreach (array_keys($_POST['items']) as $key) {
      $_POST['items'][$key]['price'] = $_POST['items'][$key]['price'] * $_POST['currency_value'];
      $_POST['items'][$key]['tax'] = $_POST['items'][$key]['tax'] * $_POST['currency_value'];
    }
    foreach (array_keys($_POST['order_total']) as $key) {
      $_POST['order_total'][$key]['value'] = $_POST['order_total'][$key]['value'] * $_POST['currency_value'];
      $_POST['order_total'][$key]['tax'] = $_POST['order_total'][$key]['tax'] * $_POST['currency_value'];
    }

    if (empty($_POST['customer']['country_code'])) $_POST['customer']['country_code'] = settings::get('default_country_code');
  }

  breadcrumbs::add(!empty($order->data['id']) ? language::translate('title_edit_order', 'Edit Order') .' #'. $order->data['id'] : language::translate('title_create_new_order', 'Create New Order'));

// Save data to database
  if (isset($_POST['save'])) {

    if (empty($_POST['items'])) $_POST['items'] = array();
    if (empty($_POST['order_total'])) $_POST['order_total'] = array();
    if (empty($_POST['comments'])) $_POST['comments'] = array();

    if (empty(notices::$data['errors'])) {

      if (!empty($_POST['items'])) {
        foreach (array_keys($_POST['items']) as $key) {
          $_POST['items'][$key]['price'] = $_POST['items'][$key]['price'] / $_POST['currency_value'];
          $_POST['items'][$key]['tax'] = $_POST['items'][$key]['tax'] / $_POST['currency_value'];
        }

        foreach (array_keys($_POST['order_total']) as $key) {
          if (empty($_POST['order_total'][$key]['calculate'])) $_POST['order_total'][$key]['calculate'] = false;
          $_POST['order_total'][$key]['value'] = $_POST['order_total'][$key]['value'] / $_POST['currency_value'];
          $_POST['order_total'][$key]['tax'] = $_POST['order_total'][$key]['tax'] / $_POST['currency_value'];
        }
      }

      $fields = array(
        'language_code',
        'currency_code',
        'currency_value',
        'items',
        'order_total',
        'order_status_id',
        'payment_option',
        'payment_transaction_id',
        'shipping_option',
        'shipping_tracking_id',
        'comments',
      );

      foreach ($fields as $field) {
        if (isset($_POST[$field])) $order->data[$field] = $_POST[$field];
      }

      $fields = array(
        'id',
        'email',
        'tax_id',
        'company',
        'firstname',
        'lastname',
        'address1',
        'address2',
        'postcode',
        'city',
        'phone',
        'mobile',
        'country_code',
        'zone_code',
        'shipping_address',
      );

      foreach ($fields as $field) {
        if (isset($_POST['customer'][$field])) $order->data['customer'][$field] = $_POST['customer'][$field];
      }

      $order->save();

    // Send e-mails
      if (!empty($_POST['email_order_copy'])) {
        $order->email_order_copy($order->data['customer']['email']);
        foreach (explode(';', settings::get('email_order_copy')) as $email) {
          if (!$email) continue;
          $order->email_order_copy($email);
        }
      }

      notices::add('success', language::translate('success_changes_saved', 'Changes saved'));
      header('Location: '. (!empty($_GET['redirect']) ? $_GET['redirect'] : document::link('', array('app' => $_GET['app'], 'doc' => 'orders'))));
      exit;
    }
  }

  // Delete from database
  if (isset($_POST['delete']) && $order) {
    $order->delete();
    notices::add('success', language::translate('success_post_deleted', 'Post deleted'));
    header('Location: '. (!empty($_GET['redirect']) ? $_GET['redirect'] : document::link('', array('app' => $_GET['app'], 'doc' => 'orders'))));
    exit;
  }

  functions::draw_lightbox();
  functions::form_draw_selectize_field('dummy');
?>
<style>
#comments {
  height: 64em;
  overflow-y: auto;
  border: 1px #ddd dashed;
  padding: 2em;
  background: #fcfcfc;
  border-radius: 0.5em;
}
#comments .comment {
  position: relative;
  margin-bottom: 1em;
  padding: 0.5em 1em;
  border-radius: 1em;
  box-sizing: border-box;
  min-height: 4em;
}
#comments .comment.system {
  margin-left: 10%;
  margin-right: 10%;
  background: #e5e5ea;
}

#comments .comment.customer {
  margin-right: 20%;
  background: #e5e5ea;
}
#comments .comment.customer:after {
  content: "";
  position: absolute;
  left: -0.5em;
  right: initial;
  bottom: 0;
  width: 1em;
  height: 1em;
  border-right: 0.5em solid #e5e5ea;
  border-bottom-right-radius: 1em 0.5em;
}

#comments .comment.staff {
  margin-left: 20%;
  background-color: #4096ee;
  color: white;
}
#comments .comment.staff:after {
  content: "";
  position: absolute;
  left: initial;
  right: -0.5em;
  bottom: 0;
  border-right: none;
  border-bottom-right-radius: 0;
  border-left: 0.5em solid #4096ee;
  border-bottom-left-radius: 1em 0.5em;
  width: 1em;
  height: 1em;
}

#comments .text {
  margin-right: 2em;
}

#comments .date {
  padding-top: 0.5em;
  font-size: 0.8em;
  text-align: center;
  opacity: 0.5;
}

#comments .remove {
  position: absolute;
  top: 0.5em;
  right: 0.5em;
  color: inherit;
}

#comments .private {
  position: absolute;
  top: 0.5em;
  right: 1.75em;
  cursor: pointer;
}
#comments .private input[name$="[hidden]"] {
  display: none;
}

#comments .semi-transparent {
  opacity: 0.5;
}

#comments textarea {
  margin-right: 2em;
  height: 4em;
  box-sizing: border-box;
  color: inherit;
  background: transparent;
  border: none;
  padding: none;
  outline: none;
  box-shadow: none;
}
</style>

<h1 style="margin-top: 0px;"><?php echo $app_icon; ?> <?php echo !empty($order->data['id']) ? language::translate('title_edit_order', 'Edit Order') .' #'. $order->data['id'] : language::translate('title_create_new_order', 'Create New Order'); ?></h1>

<?php echo functions::form_draw_form_begin('form_order', 'post'); ?>

  <div class="row">
    <div class="col-lg-8">

      <h2><?php echo language::translate('title_order_information', 'Order Information'); ?></h2>

      <div class="row">
        <div class="form-group col-md-3">
          <label><?php echo language::translate('title_language', 'Language'); ?></label>
          <?php echo functions::form_draw_languages_list('language_code', true); ?>
        </div>

        <div class="form-group col-md-3">
          <label><?php echo language::translate('title_currency', 'Currency'); ?></label>
          <?php echo functions::form_draw_currencies_list('currency_code', true); ?>
        </div>

        <div class="form-group col-md-3">
          <label><?php echo language::translate('title_currency_value', 'Currency Value'); ?></label>
          <?php echo functions::form_draw_decimal_field('currency_value', true, 3); ?>
        </div>
      </div>

      <div id="customer-details" class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title"><?php echo language::translate('title_customer_information', 'Customer Information'); ?></h2>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-md-6 customer-details">
              <div class="row">
                <div class="form-group col-md-12">
                  <label><?php echo language::translate('title_account', 'Account'); ?></label>
                  <div class="input-group">
                    <?php echo functions::form_draw_customers_list('customer[id]', true); ?>
                    <span class="input-group-btn"><?php echo functions::form_draw_button('get_address', language::translate('title_get_address', 'Get Address'), 'button'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_tax_id', 'Tax ID'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[tax_id]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_company', 'Company'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[company]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[firstname]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[lastname]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[address1]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[address2]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[postcode]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_city', 'City'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[city]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_country', 'Country'); ?></label>
                  <?php echo functions::form_draw_countries_list('customer[country_code]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
                  <?php echo form_draw_zones_list(isset($_POST['customer']['country_code']) ? $_POST['customer']['country_code'] : null, 'customer[zone_code]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_email', 'Email'); ?></label>
                  <?php echo functions::form_draw_email_field('customer[email]', true, 'required="required"'); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_phone', 'Phone'); ?></label>
                  <?php echo functions::form_draw_phone_field('customer[phone]', true); ?>
                </div>
              </div>
            </div>

            <div class="form-group col-md-6 shipping-address">
              <h3><?php echo language::translate('title_shipping_address', 'Shipping Address'); ?></h3>

              <div class="row">
                <div class="form-group col-md-12">
                  <?php echo functions::form_draw_button('copy_billing_address', language::translate('title_copy_billing_address', 'Copy Billing Address'), 'button', 'class="btn btn-default btn-block"'); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_company', 'Company'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][company]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][firstname]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][lastname]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][address1]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][address2]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][postcode]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_city', 'City'); ?></label>
                  <?php echo functions::form_draw_text_field('customer[shipping_address][city]', true); ?>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_country', 'Country'); ?></label>
                  <?php echo functions::form_draw_countries_list('customer[shipping_address][country_code]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
                  <?php echo form_draw_zones_list(isset($_POST['customer']['shipping_address']['country_code']) ? $_POST['customer']['shipping_address']['country_code'] : null, 'customer[shipping_address][zone_code]', true); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title"><?php echo language::translate('title_payment_information', 'Payment Information'); ?></h2>
            </div>

            <div class="panel-body">
              <div class="row container-fluid">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_option_id', 'Option ID'); ?></label>
                  <?php echo functions::form_draw_text_field('payment_option[id]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_name', 'Name'); ?></label>
                  <?php echo functions::form_draw_text_field('payment_option[name]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_transaction_id', 'Transaction ID'); ?></label>
                  <?php echo functions::form_draw_text_field('payment_transaction_id', true); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="panel-title"><?php echo language::translate('title_shipping_information', 'Shipping Information'); ?></h2>
            </div>

            <div class="panel-body">
              <div class="row container-fluid">
                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_option_id', 'Option ID'); ?></label>
                  <?php echo functions::form_draw_text_field('shipping_option[id]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_name', 'Name'); ?></label>
                  <?php echo functions::form_draw_text_field('shipping_option[name]', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_tracking_id', 'Tracking ID'); ?></label>
                  <?php echo functions::form_draw_text_field('shipping_tracking_id', true); ?>
                </div>

                <div class="form-group col-md-6">
                  <label><?php echo language::translate('title_weight', 'Weight'); ?></label>
                  <span class="form-control"><?php echo weight::format($order->data['weight_total'], $order->data['weight_class']) ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <h2><?php echo language::translate('title_comments', 'Comments'); ?></h2>
      <ul id="comments" class="list-unstyled">
        <?php if (!empty($_POST['comments'])) foreach (array_keys($_POST['comments']) as $key) { ?>
        <li class="comment <?php echo $_POST['comments'][$key]['author']; ?><?php echo !empty($_POST['comments'][$key]['hidden']) ? ' semi-transparent' : null; ?>">
          <?php foreach (array_keys($_POST['comments'][$key]) as $field) echo functions::form_draw_hidden_field('comments['. $key .']['. $field .']', true); ?>
          <a class="remove" href="#" title="<?php echo language::translate('title_remove', 'Remove'); ?>"><?php echo functions::draw_fonticon('fa-times-circle'); ?></a>
          <div class="text"><?php echo nl2br($_POST['comments'][$key]['text']); ?></div>
          <label class="private" title="<?php echo htmlspecialchars(language::translate('title_hidden', 'Hidden')); ?>"><?php echo functions::form_draw_checkbox('comments['.$key .'][hidden]', '1', true); ?> <?php echo functions::draw_fonticon('fa-eye'); ?></label>
          <div class="date"><?php echo strftime(language::$selected['format_datetime'], strtotime($_POST['comments'][$key]['date_created'])); ?></div>
        </li>
        <?php } ?>
        <li class="text-right"><a class="add btn btn-default" href="#" title="<?php echo language::translate('title_add', 'Add'); ?>"><?php echo functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"'); ?> <?php echo language::translate('title_add_comment', 'Add Comment'); ?></a></li>
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div id="order-items" class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title"><?php echo language::translate('title_order_items', 'Order Items'); ?></h2>
        </div>

        <div class="panel-body table-responsive">
          <table class="table table-striped data-table">
            <thead>
              <tr>
                <th><?php echo language::translate('title_item', 'Item'); ?></th>
                <th style="width: 200px;"><?php echo language::translate('title_sku', 'SKU'); ?></th>
                <th style="width: 175px;"><?php echo language::translate('title_weight', 'Weight'); ?></th>
                <th style="width: 100px;"><?php echo language::translate('title_qty', 'Qty'); ?></th>
                <th style="width: 175px;"><?php echo language::translate('title_unit_price', 'Unit Price'); ?></th>
                <th style="width: 175px;"><?php echo language::translate('title_tax', 'Tax'); ?></th>
                <th style="width: 30px;">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
<?php
  if (!empty($_POST['items'])) {
    foreach (array_keys($_POST['items']) as $key) {
?>
              <tr class="item">
                <td>
                  <?php echo !empty($_POST['items'][$key]['product_id']) ? '<a href="'. document::href_link(WS_DIR_HTTP_HOME . 'product.php', array('product_id' => $_POST['items'][$key]['product_id'])) .'" target="_blank">'. $_POST['items'][$key]['name'] .'</a>' : $_POST['items'][$key]['name']; ?></div>
                  <?php echo functions::form_draw_hidden_field('items['.$key.'][id]', true); ?>
                  <?php echo functions::form_draw_hidden_field('items['.$key.'][name]', true); ?>
                  <?php echo functions::form_draw_hidden_field('items['.$key.'][product_id]', true); ?>
                  <?php echo functions::form_draw_hidden_field('items['.$key.'][option_stock_combination]', true); ?>
<?php
      if (!empty($_POST['items'][$key]['options'])) {
        foreach (array_keys($_POST['items'][$key]['options']) as $field) {
          echo '<div class="form-inline">' . PHP_EOL
             . '  <label>'. $field .'</label>' . PHP_EOL;
          if (is_array($_POST['items'][$key]['options'][$field])) {
            foreach (array_keys($_POST['items'][$key]['options'][$field]) as $k) {
              echo '  ' . functions::form_draw_text_field('items['.$key.'][options]['.$field.']['.$k.']', true, !empty($_POST['items'][$key]['option_stock_combination']) ? 'readonly="readonly"' : '');
            }
          } else {
            echo '  ' . functions::form_draw_text_field('items['.$key.'][options]['.$field.']', true, !empty($_POST['items'][$key]['option_stock_combination']) ? 'readonly="readonly"' : '');
          }
          echo '</div>' . PHP_EOL;
        }
      } else {
        echo functions::form_draw_hidden_field('items['.$key.'][options]', '');
      }
?>
                </td>
                <td><?php echo functions::form_draw_hidden_field('items['. $key .'][sku]', true); ?><?php echo $_POST['items'][$key]['sku']; ?></td>
                <td class="text-center"><div class="input-group"><?php echo functions::form_draw_decimal_field('items['. $key .'][weight]', true, null, 0, null, 'style="width: 50%"'); ?> <?php echo functions::form_draw_weight_classes_list('items['. $key .'][weight_class]', true, false, 'style="width: 50%"'); ?></div></td>
                <td class="text-center"><?php echo functions::form_draw_decimal_field('items['. $key .'][quantity]', true, 2); ?></td>
                <td class="text-right"><?php echo functions::form_draw_currency_field($_POST['currency_code'], 'items['. $key .'][price]', true); ?></td>
                <td class="text-right"><?php echo functions::form_draw_currency_field($_POST['currency_code'], 'items['. $key .'][tax]', true); ?></td>
                <td><a class="remove" href="#" title="<?php echo language::translate('title_remove', 'Remove'); ?>"><?php echo functions::draw_fonticon('fa-times-circle fa-lg', 'style="color: #cc3333;"'); ?></a></td>
              </tr>
            </tbody>
<?php
    }
  }
?>
            <tfoot>
              <tr>
                <td colspan="7">
                  <a class="btn btn-default add-product" data-toggle="lightbox" data-title="<?php echo language::translate('title_add_product', 'Add Product'); ?>" href="<?php echo document::link('', array('doc' => 'add_product'), array('app')); ?>"><?php echo functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"'); ?> <?php echo language::translate('title_add_product', 'Add Product'); ?></a>
                  <a class="btn btn-default add-custom-item" data-toggle="lightbox" data-title="<?php echo language::translate('title_add_custom_item', 'Add Custom Item'); ?>" href="<?php echo document::link('', array('doc' => 'add_custom_item'), array('app')); ?>"><?php echo functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"'); ?> <?php echo language::translate('title_add_custom_item', 'Add Custom Item'); ?></a>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div id="order-total" class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title"><?php echo language::translate('title_order_total', 'Order Total'); ?></h2>
        </div>

        <div class="panel-body table-responsive">
          <table class="table table-striped data-table">
            <thead>
              <tr>
                <th style="width: 30px;">&nbsp;</th>
                <th><?php echo language::translate('title_module_id', 'Module ID'); ?></th>
                <th class="text-right"><?php echo language::translate('title_title', 'Title'); ?></th>
                <th style="width: 175px;"><?php echo language::translate('title_value', 'Value'); ?></th>
                <th style="width: 175px;"><?php echo language::translate('title_tax', 'Tax'); ?></th>
                <th style="width: 30px;">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
<?php
  if (empty($_POST['order_total'])) {
    $_POST['order_total'][] = array(
      'id' => '',
      'module_id' => 'ot_subtotal',
      'title' => language::translate('title_subtotal', 'Subtotal'),
      'value' => '0',
      'tax' => '0',
      'calculate' => '0',
    );
  }
  foreach (array_keys($_POST['order_total']) as $key) {
    switch($_POST['order_total'][$key]['module_id']) {
      case 'ot_subtotal':
?>
              <tr>
                <td class="text-right">&nbsp;</td>
                <td class="text-right"><?php echo functions::form_draw_hidden_field('order_total['. $key .'][id]', true) . functions::form_draw_text_field('order_total['. $key .'][module_id]', true, 'readonly="readonly"'); ?></td>
                <td class="text-right"><?php echo functions::form_draw_text_field('order_total['. $key .'][title]', true, 'class="form-control text-right"'); ?></td>
                <td class="text-right">
                  <div class="input-group">
                    <span class="input-group-addon"><?php echo functions::form_draw_checkbox('order_total['. $key .'][calculate]', '1', true, 'disabled="disabled" title="'. htmlspecialchars(language::translate('title_calculate', 'Calculate')).'"'); ?></span>
                    <?php echo functions::form_draw_currency_field($_POST['currency_code'], 'order_total['. $key .'][value]', true, 'style="text-align: right;"'); ?>
                  </div>
                </td>
                <td class="text-right"><?php echo functions::form_draw_currency_field($_POST['currency_code'], 'order_total['. $key .'][tax]', true, 'style="text-align: right;"'); ?></td>
                <td>&nbsp;</td>
              </tr>
<?php
        break;
      default:
?>
            <tr>
              <td class="text-right"><a href="#" class="add" title="<?php echo language::translate('text_insert_before', 'Insert before'); ?>"><?php echo functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"'); ?></a></td>
              <td class="text-right"><?php echo functions::form_draw_hidden_field('order_total['. $key .'][id]', true) . functions::form_draw_text_field('order_total['. $key .'][module_id]', true); ?></td>
              <td class="text-right"><?php echo functions::form_draw_text_field('order_total['. $key .'][title]', true, 'style="text-align: right;"'); ?></td>
              <td class="text-right">
                <div class="input-group">
                <span class="input-group-addon"><?php echo functions::form_draw_checkbox('order_total['. $key .'][calculate]', '1', true, 'title="'. htmlspecialchars(language::translate('title_calculate', 'Calculate')) .'"'); ?></span>
                <?php echo functions::form_draw_currency_field($_POST['currency_code'], 'order_total['. $key .'][value]', true, 'style="text-align: right;"'); ?>
                </div>
              </td>
              <td class="text-right"><?php echo functions::form_draw_currency_field($_POST['currency_code'], 'order_total['. $key .'][tax]', true, 'style="text-align: right;"'); ?></td>
              <td><a class="remove" href="#" title="<?php echo language::translate('title_remove', 'Remove'); ?>"><?php echo functions::draw_fonticon('fa-times-circle fa-lg', 'style="color: #cc3333;"'); ?></a></td>
            </tr>

<?php
        break;
    }
  }
?>
            <tr>
              <td colspan="6"><a class="add" href="#" title="<?php echo language::translate('title_insert_', 'Insert'); ?>"><?php echo functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"'); ?></a></td>
            </tr>
          </tbody>
          </tfoot>
            <tr>
              <td colspan="6" class="text-right" style="font-size: 1.5em;"><?php echo language::translate('title_payment_due', 'Payment Due'); ?>: <strong class="total"><?php echo currency::format($order->data['payment_due'], false, false, $_POST['currency_code'], $_POST['currency_value']); ?></strong></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-offset-3 col-md-3">
      <label><?php echo language::translate('title_order_status', 'Order Status'); ?></label>
      <?php echo functions::form_draw_order_status_list('order_status_id', true); ?>
    </div>

    <div class="form-group col-md-3 text-right">
      <div class="checkbox"
        <label><?php echo functions::form_draw_checkbox('email_order_copy', true); ?> <?php echo language::translate('title_send_order_copy_email', 'Send order copy email'); ?></label>
      </div>
    </div>

    <div class="col-md-3 text-right">
      <div class="btn-group">
        <?php echo functions::form_draw_button('save', language::translate('title_save', 'Save'), 'submit', '', 'save'); ?>
        <?php echo functions::form_draw_button('cancel', language::translate('title_cancel', 'Cancel'), 'button', 'onclick="history.go(-1);"', 'cancel'); ?>
        <?php echo (isset($order->data['id'])) ? functions::form_draw_button('delete', language::translate('title_delete', 'Delete'), 'submit', 'onclick="if (!confirm(\''. language::translate('text_are_you_sure', 'Are you sure?') .'\')) return false;"', 'delete') : false; ?>
      </div>
    </div>
  </div>

<?php echo functions::form_draw_form_end(); ?>

<script>
// Order

  $('select[name="currency_code"]').change(function(e){
    $('input[name="currency_value"]').val($(this).find('option:selected').data('value'));
    $('input[data-type="currency"]').closest('.input-wrapper').find('strong').text($(this).val());
    calculate_total();
  });

// Customer

  $('#customer-details button[name="get_address"]').click(function() {
    $.ajax({
      url: '<?php echo document::link('', array('doc' => 'get_address.json'), array('app')); ?>',
      type: 'post',
      data: 'customer_id=' + $('*[name="customer[id]"]').val() + '&token=<?php echo form::session_post_token(); ?>',
      cache: false,
      async: true,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn(errorThrown.message);
      },
      success: function(data) {
        $.each(data, function(key, value) {
          if (console) console.log(key +": "+ value);
          if ($('*[name="customer['+key+']"]').length) $('*[name="customer['+key+']"]').val(data[key]).trigger('change');
        });
      },
    });
  });

  $('#customer-details select[name="customer[country_code]"]').change(function() {
    $('body').css('cursor', 'wait');
    $.ajax({
      url: '<?php echo document::ilink('ajax/zones.json'); ?>?country_code=' + $(this).val(),
      type: 'get',
      cache: true,
      async: false,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        //alert(jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
      },
      success: function(data) {
        $('select[name="customer[zone_code]"]').html('');
        if ($('select[name="customer[zone_code]"]').attr('disabled')) $('select[name="customer[zone_code]"]').removeAttr('disabled');
        if (data) {
          $.each(data, function(i, zone) {
            $('select[name="customer[zone_code]"]').append('<option value="'+ zone.code +'">'+ zone.name +'</option>');
          });
        } else {
          $('select[name="customer[zone_code]"]').attr('disabled', 'disabled');
        }
      },
      complete: function() {
        $('body').css('cursor', 'auto');
      }
    });
  });

  $('#customer-details button[name="copy_billing_address"]').click(function(){
    fields = ['company', 'firstname', 'lastname', 'address1', 'address2', 'postcode', 'city', 'country_code', 'zone_code'];
    $.each(fields, function(key, field){
      $('*[name="customer[shipping_address]['+ field +']"]').val($('*[name="customer['+ field +']"]').val()).trigger('change');
    });
  });

  $('#customer-details select[name="customer[shipping_address][country_code]"]').change(function(){
    $('body').css('cursor', 'wait');
    $.ajax({
      url: '<?php echo document::ilink('ajax/zones.json'); ?>?country_code=' + $(this).val(),
      type: 'get',
      cache: true,
      async: true,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        //alert(jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
      },
      success: function(data) {
        $('select[name="customer[shipping_address][zone_code]"]').html('');
        if ($('select[name="customer[shipping_address][zone_code]"]').attr('disabled')) $('select[name="customer[shipping_address][zone_code]"]').removeAttr('disabled');
        if (data) {
          $.each(data, function(i, zone) {
            $('select[name="customer[shipping_address][zone_code]"]').append('<option value="'+ zone.code +'">'+ zone.name +'</option>');
          });
        } else {
          $('select[name="customer[shipping_address][zone_code]]"]').attr('disabled', 'disabled');
        }
      },
      complete: function() {
        $('body').css('cursor', 'auto');
      }
    });
  });

// Comments

  var new_comment_index = 0;
  $('#comments .add').click(function(event) {
    event.preventDefault();
    while ($('input[name="comments['+new_comment_index+'][id]"]').length) new_comment_index++;
    var output = '  <li class="comment staff">'
               + '    <?php echo functions::general_escape_js(functions::form_draw_hidden_field('comments[new_comment_index][id]', '') . functions::form_draw_hidden_field('comments[new_comment_index][author]', 'staff') . functions::form_draw_hidden_field('comments[new_comment_index][date_created]', strftime(language::$selected['format_datetime']))); ?>'
               + '    <a class="remove" href="#" title="<?php echo language::translate('title_remove', 'Remove'); ?>"><?php echo functions::draw_fonticon('fa-times-circle'); ?></a>'
               + '    <div class="text"><?php echo functions::general_escape_js(functions::form_draw_textarea('comments[new_comment_index][text]', '')); ?></div>'
               + '    <label class="private" title="<?php echo htmlspecialchars(language::translate('title_hidden', 'Hidden')); ?>"><?php echo functions::form_draw_checkbox('comments['.$key .'][hidden]', 1, true); ?> <?php echo functions::draw_fonticon('fa-eye'); ?></label>'
               + '    <div class="date"><?php echo strftime(language::$selected['format_datetime']); ?></div>'
               + '  </li>';
    output = output.replace(/new_comment_index/g, 'new_' + new_comment_index);
    $(this).closest('li').before(output);
    $('#comments textarea:last-child').focus();
    new_comment_index++;
  });

  $('#comments').on('click', '.remove', function(event) {
    event.preventDefault();
    $(this).closest('li').remove();
  });

  $('#comments').on('click', 'input[name^="comments"][name$="[hidden]"]', function(event) {
    if ($(this).is(':checked')) {
      $(this).closest('li').addClass('semi-transparent');
    } else {
      $(this).closest('li').removeClass('semi-transparent');
    }
  });

// Order items

  $('#order-items .add-product').click(function(){
    $(this).attr('href', '<?php echo document::link(null, array('doc' => 'add_product'), array('app')); ?>' + '&language_code=' + $('select[name="language_code"]').val() + '&currency_code=' + $('select[name="currency_code"]').val() + '&currency_value=' + $('input[name="currency_value"]').val() + '&customer%5Bcountry_code%5D=' + $('select[name="customer[country_code]"]').val() + '&customer%5Bzone_code%5D=' + ($('select[name="customer[zone_code]"]').val() ? $('select[name="customer[zone_code]"]').val() : "") + '&customer%5Bcompany%5D=' + $('input[name="customer[company]"]').val());
  });

  $('#order-items .add-custom-item').click(function(){
    $(this).attr('href', '<?php echo document::link(null, array('doc' => 'add_custom_item'), array('app')); ?>' + '&language_code=' + $('select[name="language_code"]').val() + '&currency_code=' + $('select[name="currency_code"]').val() + '&currency_value=' + $('input[name="currency_value"]').val() + '&customer%5Bcountry_code%5D=' + $('select[name="customer[country_code]"]').val() + '&customer%5Bzone_code%5D=' + $('select[name="customer[zone_code]"]').val() + '&customer%5Bcompany%5D=' + $('input[name="customer[company]"]').val());
  });

  var new_item_index = 0;
  function addItem(item) {
    new_item_index++;

    var output = '  <tr class="item">'
               + '    <td>' + item.name
               + '      <?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][id]', '')); ?>'
               + '      <?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][product_id]', '')); ?>'
               + '      <?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][option_stock_combination]', '')); ?>'
               + '      <?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][options]', '')); ?>'
               + '      <?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][name]', '')); ?>'
               + '    </td>'
               + '    <td><?php echo functions::general_escape_js(functions::form_draw_hidden_field('items[new_item_index][sku]', '')); ?>'+ item.sku +'</td>'
               + '    <td><div class="input-group"><?php echo functions::general_escape_js(functions::form_draw_decimal_field('items[new_item_index][weight]', '', null, 0, null, 'style="width: 50%"')); ?> <?php echo str_replace(PHP_EOL, '', functions::form_draw_weight_classes_list('items[new_item_index][weight_class]', '', false, 'style="width: 50%"')); ?></div></td>'
               + '    <td><?php echo functions::general_escape_js(functions::form_draw_decimal_field('items[new_item_index][quantity]', '', 2)); ?></td>'
               + '    <td><?php echo functions::general_escape_js(functions::form_draw_currency_field($_POST['currency_code'], 'items[new_item_index][price]', '')); ?></td>'
               + '    <td><?php echo functions::general_escape_js(functions::form_draw_currency_field($_POST['currency_code'], 'items[new_item_index][tax]', '')); ?></td>'
               + '    <td><a class="remove" href="#" title="<?php echo functions::general_escape_js(language::translate('title_remove', 'Remove'), true); ?>"><?php echo functions::general_escape_js(functions::draw_fonticon('fa-times-circle fa-lg', 'style="color: #cc3333;"')); ?></a></td>'
               + '  </tr>';
    output = output.replace(/new_item_index/g, 'new_' + new_item_index);
    $('#order-items tbody').append(output);

    var row = $('#order-items tbody tr.item').last();
    $(row).find('*[name$="[product_id]"]').val(item.product_id);
    $(row).find('*[name$="[sku]"]').val(item.sku);
    $(row).find('*[name$="[option_stock_combination]"]').val(item.option_stock_combination);
    $(row).find('*[name$="[name]"]').val(item.name);
    $(row).find('*[name$="[sku]"]').val(item.sku);
    $(row).find('*[name$="[weight]"]').val(item.weight);
    $(row).find('*[name$="[weight_class]"]').val(item.weight_class);
    $(row).find('*[name$="[quantity]"]').val(item.quantity);
    $(row).find('*[name$="[price]"]').val(item.price);
    $(row).find('*[name$="[tax]"]').val(item.tax);

    if (item.options) {
      var product_options = '';
      $.each(item.options, function(group, value) {
        product_options += '<div class="form-inline">'
                         + '  <label>'+ group +'</label>';
        if ($.isArray(value)) {
          $.each(value, function(i, array_value) {
            product_options += '  <input class="form-control" type="text" name="items[new_'+ new_item_index +'][options]['+ group +'][]" value="'+ array_value +'" />';
          });
        } else {
          product_options += '  <input class="form-control" type="text" name="items[new_'+ new_item_index +'][options]['+ group +']" value="'+ value +'" />';
        }
        product_options += '</div>';
      });
      $(row).find('input[type="hidden"][name$="[options]"]').replaceWith(product_options);
    }

    calculate_total();
  }

  $('#order-items').on('click', '.remove', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
  });

// Order Total

  var new_ot_row_index = 0;
  $('#order-total').on('click', '.add', function(event) {
    while ($('input[name="order_total['+new_ot_row_index+'][id]"]').length) new_ot_row_index++;
    event.preventDefault();
    var output = '  <tr>'
               + '    <td class="text-right"><a href="#" class="add" title="<?php echo functions::general_escape_js(language::translate('text_insert_before', 'Insert before'), true); ?>"><?php echo functions::general_escape_js(functions::draw_fonticon('fa-plus-circle', 'style="color: #66cc66;"')); ?></a></td>'
               + '    <td class="text-right"><?php echo functions::general_escape_js(functions::form_draw_hidden_field('order_total[new_ot_row_index][id]', '')); ?><?php echo functions::general_escape_js(functions::form_draw_text_field('order_total[new_ot_row_index][module_id]', '')); ?></td>'
               + '    <td class="text-right"><?php echo functions::general_escape_js(functions::form_draw_text_field('order_total[new_ot_row_index][title]', '', 'style="text-align: right;"')); ?></td>'
               + '    <td class="text-right">'
               + '      <div class="input-group">'
               + '        <span class="input-group-addon"><?php echo functions::general_escape_js(functions::form_draw_checkbox('order_total[new_ot_row_index][calculate]', '1', '1', '', language::translate('title_calculate', 'Calculate'))); ?></span>'
               + '        <?php echo functions::general_escape_js(functions::form_draw_currency_field($_POST['currency_code'], 'order_total[new_ot_row_index][value]', currency::format(0, false, true), 'style="text-align: right;"')); ?>'
               + '      </div>'
               + '    </td>'
               + '    <td class="text-right"><?php echo functions::general_escape_js(functions::form_draw_currency_field($_POST['currency_code'], 'order_total[new_ot_row_index][tax]', currency::format(0, false, true), 'style="text-align: right;"')); ?></td>'
               + '    <td><a class="remove" href="#" title="<?php echo functions::general_escape_js(language::translate('title_remove', 'Remove'), true); ?>"><?php echo functions::general_escape_js(functions::draw_fonticon('fa-times-circle fa-lg', 'style="color: #cc3333;"')); ?></a></td>'
               + '  </tr>';
  output = output.replace(/new_ot_row_index/g, 'new_' + new_ot_row_index);
  $(this).closest('tr').before(output);
  new_ot_row_index++;
  });

  $('#order-total').on('click', '.remove', function(event) {
    event.preventDefault();
  $(this).closest('tr').remove();
  });

  function calculate_total() {
    var subtotal = 0;
    $('input[name^="items["][name$="[price]"]').each(function() {
      subtotal += Number($(this).val()) * Number($(this).closest('tr').find('input[name^="items["][name$="[quantity]"]').val());
    });
    subtotal = Math.round(subtotal * Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'))) / Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'));
    $('input[name^="order_total["][value="ot_subtotal"]').closest('tr').find('input[name^="order_total["][name$="[value]"]').val(subtotal);

    var subtotal_tax = 0;
    $('input[name^="items["][name$="[tax]"]').each(function() {
      subtotal_tax += Number($(this).val()) * Number($(this).closest('tr').find('input[name^="items["][name$="[quantity]"]').val());
    });
    subtotal_tax = Math.round(subtotal_tax * Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'))) / Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'));
    $('input[name^="order_total["][value="ot_subtotal"]').closest('tr').find('input[name^="order_total["][name$="[tax]"]').val(subtotal_tax);

    var order_total = subtotal + subtotal_tax;
    $('input[name^="order_total["][name$="[value]"]').each(function() {
      if ($(this).closest('tr').find('input[name^="order_total["][name$="[calculate]"]').is(':checked')) {
        order_total += Number(Number($(this).val()));
      }
    });
    $('input[name^="order_total["][name$="[tax]"]').each(function() {
      if ($(this).closest('tr').find('input[name^="order_total["][name$="[calculate]"]').is(':checked')) {
        order_total += Number($(this).val());
      }
    });
    order_total = Math.round(order_total * Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'))) / Math.pow(10, $('select[name="currency_code"] option:selected').data('decimals'));
    $('#order-total .total').text($('select[name="currency_code"] option:selected').data('prefix') + order_total + $('select[name="currency_code"] option:selected').data('suffix'));
  }

  $('body').on('click keyup', 'input[name^="items"][name$="[price]"], input[name^="items"][name$="[tax]"], input[name^="items"][name$="[quantity]"], input[name^="order_total"][name$="[value]"], input[name^="order_total"][name$="[tax]"], input[name^="order_total"][name$="[calculate]"], #order-items a.remove, #order-total a.remove', function() {
    calculate_total();
  });
</script>