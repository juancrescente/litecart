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

    if (!$('body > .loader-wrapper').length) {
      var progress_bar = '<div class="loader-wrapper">'
                       + '  <img class="loader" style="width: 256px; height: 256px;" alt="" />'
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
            $('body > .loader-wrapper').fadeOut('fast', function(){$(this).remove();});
        }
        queueRunLock = false;
        runQueue();
      }
    });
  }

  runQueue();

// Cart

  $('body').on('click', '#checkout-cart button[name="remove_cart_item"]', function(e){
    e.preventDefault();
    var data = $(this).closest('td').find(':input').serialize() + '&remove_cart_item=' + $(this).val();
    queueUpdateTask('cart', data);
    queueUpdateTask('shipping');
    queueUpdateTask('payment');
    queueUpdateTask('summary');
  });

  $('body').on('click', '#checkout-cart button[name="update_cart_item"]', function(e){
    e.preventDefault();
    var data = $(this).closest('td').find(':input').serialize() + '&update_cart_item=' + $(this).val();
    queueUpdateTask('cart', data);
    queueUpdateTask('shipping');
    queueUpdateTask('payment');
    queueUpdateTask('summary');
  });

// Customer Form: Toggles

  $('#checkout-customer-wrapper').on('change', 'input[name="different_shipping_address"]', function(e){
    if (this.checked == true) {
      $('#shipping-address-container').slideDown('fast');
    } else {
      $('#shipping-address-container').slideUp('fast');
    }
  });

  $('#checkout-customer-wrapper').on('change', 'input[name="create_account"]', function(){
    if (this.checked == true) {
      $('#account-container').slideDown('fast');
    } else {
      $('#account-container').slideUp('fast');
    }
  });

// Customer Form: Get Address

  $('#checkout-customer').on('change', '.billing-address :input', function() {
    if ($(this).val() == '') return;
    if (console) console.log('Retrieving address (Trigger: "'+ $(this).attr('name') +')');
    $.ajax({
      url: '<?php echo document::ilink('ajax/get_address.json'); ?>?trigger='+$(this).attr('name'),
      type: 'post',
      data: $('.billing-address :input').serialize(),
      cache: false,
      async: false,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn(errorThrown.message + "\n" + jqXHR.responseText);
      },
      success: function(data) {
        if (data['alert']) alert(data['alert']);
        if (console) console.log(data);
        $.each(data, function(key, value) {
          if ($(".billing-address *[name='"+key+"']").length && $(".billing-address *[name='"+key+"']").val() == '') {
            $(".billing-address *[name='"+key+"']").val(value);
          }
        });
      },
    });
  });

// Customer Form: Chained Select

  $('#checkout-customer').on('change', 'select[name="country_code"]', function() {
    if ($(this).find('option:selected').data('tax-id-format') != '') {
      $(this).closest('table').find("input[name='tax_id']").attr('pattern', $(this).find('option:selected').data('tax-id-format'));
    } else {
      $(this).closest('table').find("input[name='tax_id']").removeAttr('pattern');
    }

    if ($(this).find('option:selected').data('postcode-format') != '') {
      $(this).closest('table').find("input[name='postcode']").attr('pattern', $(this).find('option:selected').data('postcode-format'));
      $(this).closest('table').find("input[name='postcode']").attr('required', 'required');
      $(this).closest('table').find("input[name='postcode']").closest('td').find('.required').show();
    } else {
      $(this).closest('table').find("input[name='postcode']").removeAttr('pattern');
      $(this).closest('table').find("input[name='postcode']").removeAttr('required');
      $(this).closest('table').find("input[name='postcode']").closest('td').find('.required').hide();
    }

    if ($(this).find('option:selected').data('phone-code') != '') {
      $(this).closest('table').find("input[name='phone']").attr('placeholder', '+' + $(this).find('option:selected').data('phone-code'));
    } else {
      $(this).closest('table').find("input[name='phone']").removeAttr('placeholder');
    }

    $('body').css('cursor', 'wait');
    $.ajax({
      url: '<?php echo document::ilink('ajax/zones.json'); ?>?country_code=' + $(this).val(),
      type: 'get',
      cache: true,
      async: true,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn(errorThrown.message);
      },
      success: function(data) {
        $("select[name='zone_code']").html('');
        if (data) {
          $("select[name='zone_code']").removeAttr('disabled');
          $("select[name='zone_code']").closest('td').css('opacity', 1);
          $.each(data, function(i, zone) {
            $("select[name='zone_code']").append('<option value="'+ zone.code +'">'+ zone.name +'</option>');
          });
        } else {
          $("select[name='zone_code']").attr('disabled', 'disabled');
          $("select[name='zone_code']").closest('td').css('opacity', 0.15);
        }
      },
      complete: function() {
        $('body').css('cursor', 'auto');
      }
    });
  });
  
  $('#checkout-customer').on('change', 'select[name="shipping_address[country_code]"]', function() {
    if ($(this).find('option:selected').data('postcode-format') != '') {
      $(this).closest('table').find("input[name='shipping_address[postcode]']").attr('pattern', $(this).find('option:selected').data('postcode-format'));
      $(this).closest('table').find("input[name='shipping_address[postcode]']").attr('required', 'required');
      $(this).closest('table').find("input[name='shipping_address[postcode]']").closest('td').find('.required').show();
    } else {
      $(this).closest('table').find("input[name='shipping_address[postcode]']").removeAttr('pattern');
      $(this).closest('table').find("input[name='shipping_address[postcode]']").removeAttr('required');
      $(this).closest('table').find("input[name='shipping_address[postcode]']").closest('td').find('.required').hide();
    }

    console.log('Retrieving zones');
    $('body').css('cursor', 'wait');
    $.ajax({
      url: '<?php echo document::ilink('ajax/zones.json'); ?>?country_code=' + $(this).val(),
      type: 'get',
      cache: true,
      async: false,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn(errorThrown.message);
      },
      success: function(data) {
        $("select[name='shipping_address[zone_code]']").html('');
        if (data) {
          $("select[name='shipping_address[zone_code]']").removeAttr('disabled');
          $("select[name='shipping_address[zone_code]']").closest('td').css('opacity', 1);
          $.each(data, function(i, zone) {
            $("select[name='shipping_address[zone_code]']").append('<option value="'+ zone.code +'">'+ zone.name +'</option>');
          });
        } else {
          $("select[name='shipping_address[zone_code]']").attr('disabled', 'disabled');
          $("select[name='shipping_address[zone_code]']").closest('td').css('opacity', 0.15);
        }
      },
      complete: function() {
        $('body').css('cursor', 'auto');
      }
    });
  });

// Customer Form: Auto-Save

  var customer_form_changed = false;
  var customer_form_checksum = $('#checkout-customer :input').serialize();
  $('body').on('change keyup', '#checkout-customer', function(e) {
    if ($('#checkout-customer :input').serialize() != customer_form_checksum) {
      customer_form_changed = true;
      $('#checkout-customer button[name="save_customer_details"]').removeAttr('disabled');
    } else {
      customer_form_changed = false;
      $('#checkout-customer button[name="save_customer_details"]').attr('disabled', 'disabled');
    }
  });

  var timerSubmitCustomer;
  $('body').on('focusout', '#checkout-customer', function() {
    timerSubmitCustomer = setTimeout(
      function() {
        if (!$(this).is(':focus')) {
          if (customer_form_changed) {
            if (console) console.log('Autosaving customer details');
            var data = $('#checkout-customer :input').serialize();
            queueUpdateTask('customer', data);
            queueUpdateTask('cart');
            queueUpdateTask('shipping');
            queueUpdateTask('payment');
            queueUpdateTask('summary');
          }
        }
      }, 50
    );
  });

  $('body').on('focusin', '#checkout-customer', function() {
    clearTimeout(timerSubmitCustomer);
  });

// Process Customer Data

  $('body').on('click', '#checkout-customer button[name="save_customer_details"]', function(e){
    e.preventDefault();
    var data = $('#checkout-customer :input').serialize() + '&save_customer_details=true';
    queueUpdateTask('customer', data);
    queueUpdateTask('cart');
    queueUpdateTask('shipping');
    queueUpdateTask('payment');
    queueUpdateTask('summary');
    customer_form_checksum = $('#checkout-customer :input').serialize();
    $('#checkout-customer :input:first-child').trigger('change');
  });

// Process Shipping Data

  $('#checkout-shipping-wrapper').on('click', '.option:not(.active):not(.disabled)', function(){
    $('#checkout-shipping .option').removeClass('active');
    $(this).find('input[name="shipping[option_id]"]').prop('checked', true);
    $(this).addClass('active');
    var data = $('#checkout-shipping .option.active :input').serialize();
    queueUpdateTask('shipping', data, false);
    queueUpdateTask('payment');
    queueUpdateTask('summary');
  });

// Process Payment Data

  $('#checkout-payment-wrapper').on('click', '.option:not(.active):not(.disabled)', function(){
    $('#checkout-payment .option').removeClass('active');
    $(this).find('input[name="payment[option_id]"]').prop('checked', true);
    $(this).addClass('active');
    var data = $('#checkout-payment .option.active :input').serialize();
    queueUpdateTask('payment', data, false);
    queueUpdateTask('summary');
  });

// Process Summary

  $('body').on('click', '#checkout-summary button[name="confirm_order"]', function(e) {
    if (customer_form_changed) {
      e.preventDefault();
      alert("<?php echo language::translate('warning_your_customer_information_unsaved', 'Your customer information contains unsaved changes.')?>");
    }
  });

  $("body").on('submit', 'form[name="checkout_form"]', function(e) {
    $('#checkout-summary button[name="confirm_order"]').css('display', 'none').before('<div class="btn btn-block btn-default btn-lg disabled"><?php echo functions::draw_fonticon('fa-spinner'); ?> <?php echo htmlspecialchars(language::translate('text_please_wait', 'Please wait')); ?>&hellip;</div>');
  });
</script>