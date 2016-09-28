<!--snippet:notices-->

<div id="checkout-cart-wrapper">
  {snippet:box_checkout_cart}
</div>

<?php echo functions::form_draw_form_begin('checkout_form', 'post'); ?>

  <div class="row">
    <div class="col-md-6">
      <div id="checkout-customer-wrapper">
       {snippet:box_checkout_customer}
      </div>
    </div>

    <div class="col-md-6">
      <div id="checkout-shipping-wrapper">
      </div>

      <div id="checkout-payment-wrapper">
        {snippet:box_checkout_payment}
      </div>
    </div>
  </div>

  <div id="checkout-summary-wrapper">
    {snippet:box_checkout_summary}
  </div>

<?php echo functions::form_draw_form_end(); ?>

<script>
// Queue Handler

  var updateQueue = [
    ['cart', null, true],
    ['customer', null, true],
    ['shipping', null, true],
    ['payment', null, true],
    ['summary', null, true]
  ];

  function queueUpdateTask(component, data=null, refresh=true) {
    updateQueue = jQuery.grep(updateQueue, function(tasks) {
      return (tasks[0] == component) ? false : true;
    });

    updateQueue.push([component, data, refresh]);

    runQueue();
  }

  var queueRunLock = false;
  function runQueue() {

    if (queueRunLock) return;

    if (updateQueue.length == 0) return;

    queueRunLock = true;

    task = updateQueue.shift();

    if (console) console.log('Processing #checkout-' + task[0] + '-wrapper...');

    if (!$('body > .loader').length) {
      var progress_bar = '<div class="loader" style="position: fixed; top: 50%; left: 10%; right: 10%; text-align: center; font-size: 256px; margin-top: -128px; opacity: 0.05; z-index: 999999;">'
                       + '  <i class="fa fa-spinner fa-spin"></i>'
                       + '</div>';
      var progress_bar = '<div class="loader">'
                       + '  <img alt="" />'
                       + '</div>';
      $('body').append(progress_bar);
    }

    if (task[2]) $('#checkout-'+ task[0] +'-wrapper').fadeTo('fast', 0.15);

    var url = '';
    switch(task[0]) {
      case 'cart':
        url = '<?php echo document::ilink('ajax/checkout_cart.html'); ?>';
        break;
      case 'customer':
        url = '<?php echo document::ilink('ajax/checkout_customer.html'); ?>';
        break;
      case 'shipping':
        url = '<?php echo document::ilink('ajax/checkout_shipping.html'); ?>';
        break;
      case 'payment':
        url = '<?php echo document::ilink('ajax/checkout_payment.html'); ?>';
        break;
      case 'summary':
        url = '<?php echo document::ilink('ajax/checkout_summary.html'); ?>';
        break;
      default:
        alert('Error: Invalid component ' + task[0]);
        break;
    }

    $.ajax({
      type: 'post',
      url: url,
      data: task[1],
      dataType: 'html',
      beforeSend: function(jqXHR) {
        jqXHR.overrideMimeType('text/html;charset=<?php echo language::$selected['charset']; ?>');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn("Error");
        $('#checkout-'+ task[0] +'-wrapper').html(textStatus + ': ' + errorThrown);
      },
      success: function(html) {
        if (task[2]) $('#checkout-'+ task[0] +'-wrapper').html(html).fadeTo('fast', 1);
      },
      complete: function(html) {
        if (!updateQueue.length) {
            $('body > .loader').fadeOut('fast', function(){$(this).remove();});
        }
        queueRunLock = false;
        runQueue();
      }
    });
  }

  runQueue();

// Cart

  $('body').on('click', '#checkout-cart-wrapper button[name="update_cart_item"]', function(e){
    var data = $(this).closest('td').find(':input').serialize() + '&update_cart_item=' + $(this).val();
    queueUpdateTask('cart', data);
    queueUpdateTask('shipping');
    queueUpdateTask('payment');
    queueUpdateTask('summary');
  });

// Customer

  $('body').on('click', '#checkout-customer-wrapper button[name="save_customer_details"]', function(e){
    e.preventDefault();
    var data = $('#checkout-customer-wrapper :input').serialize() + "save_customer_details=true";
    queueUpdateTask('customer', data);
    queueUpdateTask('cart');
    queueUpdateTask('shipping');
    queueUpdateTask('payment');
    queueUpdateTask('summary');
    customer_form_checksum = $('#checkout-customer-wrapper :input').serialize();
    $('#checkout-customer-wrapper :input:first-child').trigger('change');
  });

// Shipping

  $('#checkout-shipping-wrapper').on('click', '.option:not(.active):not(.disabled)', function(){
    $('#checkout-shipping .option').removeClass('active');
    $(this).find('input[name="shipping[option_id]"]').prop('checked', true);
    $(this).addClass('active');

    var data = $('#checkout-shipping-wrapper .option.active :input').serialize();
    queueUpdateTask('shipping', data, false);
    queueUpdateTask('payment');
    queueUpdateTask('summary');
  });

// Payment

  $('#checkout-payment-wrapper').on('click', '.option:not(.active):not(.disabled)', function(){
    $('#checkout-payment .option').removeClass('active');
    $(this).find('input[name="payment[option_id]"]').prop('checked', true);
    $(this).addClass('active');

    var data = $('#checkout-payment-wrapper .option.active :input').serialize();
    queueUpdateTask('payment', data, false);
    queueUpdateTask('summary');
  });

// Summary

  $("body").on('click', '#checkout-summary-wrapper button[name="confirm_order"]', function(e) {
    if (customer_form_changed) {
      e.preventDefault();
      alert("<?php echo language::translate('warning_your_customer_information_unsaved', 'Your customer information contains unsaved changes.')?>");
    }
  });

  $("body").on('submit', 'form[name="checkout_form"]', function(e) {
    $('#checkout-summary-wrapper button[name="confirm_order"]').css('display', 'none').before('<div class="btn btn-block btn-default btn-lg disabled"><?php echo functions::draw_fonticon('fa-spinner'); ?> <?php echo htmlspecialchars(language::translate('text_please_wait', 'Please wait')); ?>&hellip;</div>');
  });
</script>