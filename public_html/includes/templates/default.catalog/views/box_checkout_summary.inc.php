<div id="checkout-summary">
  <h2><?php echo language::translate('title_order_summary', 'Order Summary'); ?></h2>
  
  <div id="order_confirmation-wrapper">
  
    <table class="table table-striped data-table">
      <thead>
        <tr class="header">
          <th class="quantity text-center"><?php echo language::translate('title_qty', 'Qty'); ?></th>
          <th class="name"><?php echo language::translate('title_product', 'Product'); ?></th>
          <th class="sku"><?php echo language::translate('title_sku', 'SKU'); ?></th>
          <th class="unit-price text-right"><?php echo language::translate('title_unit_price', 'Unit Price'); ?></th>
          <th class="tax text-right"><?php echo !empty(customer::$data['display_prices_including_tax']) ? language::translate('title_incl_tax', 'Incl. Tax') : language::translate('title_excl_tax', 'Excl. Tax'); ?></th>
          <th class="sum text-right"><?php echo language::translate('title_total', 'Total'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item) { ?>
        <tr>
          <td class="quantity text-center"><?php echo $item['quantity']; ?></td>
          <td class="name"><?php echo $item['name']; ?></td>
          <td class="sku"><?php echo $item['sku']; ?></td>
          <td class="unit-price text-right"><?php echo $item['price']; ?></td>
          <td class="tax text-right"><?php echo $item['tax']; ?></td>
          <td class="sum text-right"><?php echo $item['sum']; ?></td>
        </tr>
        <?php } ?>
       
        <?php foreach ($order_total as $row) { ?>
        <tr>
          <td colspan="5" style="text-align: right;"><strong><?php echo $row['title']; ?>:</strong></td>
          <td style="text-align: right;"><?php echo $row['value']; ?></td>
        </tr>
        <?php } ?>
      
        <?php if ($tax_total) { ?>
        <tr>
          <td colspan="5" style="text-align: right; color: #999999;"><?php echo $incl_excl_tax; ?>:</td>
          <td style="text-align: right; color: #999999;"><?php echo $tax_total; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="footer">
          <td colspan="5" style="text-align: right;"><strong><?php echo language::translate('title_payment_due', 'Payment Due'); ?>:</strong></td>
          <td style="text-align: right;"><strong><?php echo $payment_due; ?></strong></td>
        </tr>
      </tfoot>
    </table>
    
    <?php echo functions::form_draw_form_begin('order_form', 'post', document::ilink('order_process'));  ?>
      <div class="comments form-group">
        <label><?php echo language::translate('title_comments', 'Comments'); ?></label>
        <?php echo functions::form_draw_textarea('comments', true); ?>
      </div>
      
      <div class="confirm row">
        <div class="col-md-9">
          <?php if ($error) echo '<div class="alert alert-warning">'. $error .'</div>' . PHP_EOL; ?>
        </div>
        
        <div class="col-md-3">
          <?php //echo functions::form_draw_button('confirm_order', $confirm, 'submit', 'style="width: 100%;"' . (!empty($error) ? ' disabled="disabled"' : '')); ?>
          <button class="btn btn-block btn-lg btn-default btn-success" name="confirm_order" value="true"<?php echo !empty($error) ? ' disabled="disabled"' : ''; ?>><?php echo $confirm; ?></button>
        </div>
      </div>

    <?php echo functions::form_draw_form_end(); ?>
  </div>
</div>