<!--snippet:notices-->

<?php echo functions::form_draw_form_begin('checkout_form', 'post'); ?>

  <div id="checkout-cart-wrapper">
  {snippet:box_checkout_cart}
  </div>

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
  var updateQueue = [];
  function queueUpdateTask(component, data) {
    updateQueue = jQuery.grep(updateQueue, function(tasks) {
      return (tasks[0] == component) ? false : true;
    });

    updateQueue.push([component, data]);

    runQueue();
  }

  var queueRunLock = false;
  function runQueue() {

    if (queueRunLock) return;

    if (updateQueue.length == 0) return;

    queueRunLock = true;

    task = updateQueue.shift();

    if (console) console.log('Refreshing ' + task[0] + '...');

    if (!$('#loading').length) {
      var progress_bar = '<div id="loading" style="position: fixed; top: 50%; left: 10%; right: 10%; text-align: center; font-size: 256px; margin-top: -128px; opacity: 0.05; z-index: 999999;">'
                       + '  <i class="fa fa-spinner fa-spin"></i>'
                       + '</div>';
      $('body').append(progress_bar);
    }

    $('#checkout-'+ task[0] +'-wrapper').fadeTo('fast', 0.15);

    $.ajax({
      type: 'post',
      url: '?return='+task[0],
      data: $('form[name="checkout_form"]').serialize(),
      dataType: 'html',
      beforeSend: function(jqXHR) {
        jqXHR.overrideMimeType('text/html;charset=<?php echo language::$selected['charset']; ?>');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn("Error");
        $('#checkout-'+ task[0] +'-wrapper').html(textStatus + ': ' + errorThrown);
      },
      success: function(html) {
        console.log(task[0] + ' refreshed');
        $('#checkout-'+ task[0] +'-wrapper').html(html).fadeTo('fast', 1);
      },
      complete: function(html) {
        if (!updateQueue.length) $('body #loading').remove();
        queueRunLock = false;
        runQueue();
      }
    });
  }

  /*
  $('body').on('change', '#checkout-cart-wrapper :input', function(e){
    var data = $('form[name="checkout_form"]').serialize();
    queueUpdateTask('cart', data);
    queueUpdateTask('shipping', data);
    queueUpdateTask('payment', data);
    queueUpdateTask('summary', data);
  });
  */

// Customer form
  var customer_form_changed = false;
  var customer_form_checksum = $('form[name="checkout_form"]').find('#checkout-customer-wrapper :input').serialize();
  $("body").on('change keyup', '#checkout-customer-wrapper', function(e) {
    if ($('form[name="checkout_form"]').find('#checkout-customer-wrapper :input').serialize() != customer_form_checksum) {
      customer_form_changed = true;
      $('#checkout-customer-wrapper button[name="save_address"]').removeAttr('disabled');
    } else {
      customer_form_changed = false;
      $('#checkout-customer-wrapper button[name="save_address"]').attr('disabled', 'disabled');
    }
  });

  var timerSubmitCustomer;
  $("body").on('focusout', '#checkout-customer-wrapper', function() {
    timerSubmitCustomer = setTimeout(
      function() {
        if (!$(this).is(':focus')) {
          if (customer_form_changed) {
            if (console) console.log('Autosaving customer details');
            var data = $('form[name="checkout_form"]').serialize();
            queueUpdateTask('cart', data);
            queueUpdateTask('customer', data);
            queueUpdateTask('payment', data);
            queueUpdateTask('summary', data);
            customer_form_checksum = $('form[name="checkout_form"]').find('#checkout-customer-wrapper :input').serialize();
            customer_form_changed = false;
          }
        }
      }, 50
    );
  });

  $("body").on('focusin', '#checkout-customer-wrapper', function() {
    clearTimeout(timerSubmitCustomer);
  });

  $('body').on('click', '#checkout-customer-wrapper button[name="save_address"]', function(e){
    e.preventDefault();
    var data = $('form[name="checkout_form"]').serialize();
    queueUpdateTask('cart', data);
    queueUpdateTask('customer', data);
    queueUpdateTask('payment', data);
    queueUpdateTask('summary', data);
    customer_form_checksum = $('form[name="checkout_form"]').find('#checkout-customer-wrapper :input').serialize();
    customer_form_changed = false;
  });

  $('body').on('change', '#checkout-shipping-wrapper :input', function(e){
    var data = $('form[name="checkout_form"]').serialize();
    queueUpdateTask('payment', data);
    queueUpdateTask('summary', data);
  });

  $('body').on('change', '#checkout-payment-wrapper :input', function(e){
    var data = $('form[name="checkout_form"]').serialize();
    queueUpdateTask('summary', data);
  });

  $("body").on('click', '#checkout-summary-wrapper button[name="confirm_order"]', function(e) {
    if (customer_form_changed) {
      e.preventDefault();
      alert("<?php echo language::translate('warning_your_customer_information_unsaved', 'Your customer information contains unsaved changes.')?>");
    }
  });

  $("body").on('submit', 'form[name="checkout_form"]', function(e) {
    $('#checkout-summary-wrapper button[name="confirm_order"]').prepend('<i class="fa fa-spinner fa-spin"></i> ');
  });

  queueUpdateTask('cart');
  queueUpdateTask('customer');
  queueUpdateTask('shipping');
  queueUpdateTask('payment');
  queueUpdateTask('summary');
</script>