<div id="checkout-customer" class="panel panel-default">
  <div class="panel-heading">
    <h2 class="panel-title title"><?php echo language::translate('title_customer_details', 'Customer Details'); ?></h2>
  </div>

  <div class="panel-body">

    <div class="address billing-address">

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_tax_id', 'Tax ID'); ?></label>
              <?php echo functions::form_draw_text_field('tax_id', true); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_company', 'Company'); ?></label>
              <?php echo functions::form_draw_text_field('company', true); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
              <?php echo functions::form_draw_text_field('firstname', true, 'required="required"'); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
              <?php echo functions::form_draw_text_field('lastname', true, 'required="required"'); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
              <?php echo functions::form_draw_text_field('address1', true, 'required="required"'); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
            <?php echo functions::form_draw_text_field('address2', true); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
              <?php echo functions::form_draw_text_field('postcode', true); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_city', 'City'); ?></label>
              <?php echo functions::form_draw_text_field('city', true); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_country', 'Country'); ?></label>
              <?php echo functions::form_draw_countries_list('country_code', true); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
              <?php echo form_draw_zones_list(isset($_POST['country_code']) ? $_POST['country_code'] : '', 'zone_code', true); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_email', 'Email'); ?></label>
              <?php echo functions::form_draw_email_field('email', true, 'required="required"'. (!empty(customer::$data['id']) ? ' readonly="readonly"' : '')); ?>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo language::translate('title_phone', 'Phone'); ?></label>
              <?php echo functions::form_draw_phone_field('phone', true, 'required="required"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="address shipping-address">

      <h3><?php echo functions::form_draw_checkbox('different_shipping_address', '1', !empty($_POST['different_shipping_address']) ? '1' : '', 'style="margin: 0px;"'); ?> <?php echo language::translate('title_different_shipping_address', 'Different Shipping Address'); ?></h3>

      <div id="shipping-address-container"<?php echo (empty($_POST['different_shipping_address'])) ? ' style="display: none;"' : false; ?>>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_company', 'Company'); ?></label>
                <?php echo functions::form_draw_text_field('company', true); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
                <?php echo functions::form_draw_text_field('firstname', true, 'required="required"'); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
                <?php echo functions::form_draw_text_field('lastname', true, 'required="required"'); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
                <?php echo functions::form_draw_text_field('address1', true, 'required="required"'); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
              <?php echo functions::form_draw_text_field('address2', true); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
                <?php echo functions::form_draw_text_field('postcode', true); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_city', 'City'); ?></label>
                <?php echo functions::form_draw_text_field('city', true); ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_country', 'Country'); ?></label>
                <?php echo functions::form_draw_countries_list('country_code', true); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
                <?php echo form_draw_zones_list(isset($_POST['country_code']) ? $_POST['country_code'] : '', 'zone_code', true); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="account">

      <h3><?php echo functions::form_draw_checkbox('create_account', '1', !empty($_POST['create_account']) ? '1' : '', 'style="margin: 0px;"'); ?> <?php echo language::translate('title_create_account', 'Create Account'); ?></h3>

      <div id="account-container"<?php echo (empty($_POST['create_account'])) ? ' style="display: none;"' : false; ?>>

        <?php //if (empty(customer::$data['id']) && settings::get('register_guests') && settings::get('fields_customer_password')) { ?>
        <?php //if (empty($_POST['email']) || !database::num_rows(database::query("select id from ". DB_TABLE_CUSTOMERS ." where email = '". database::input($_POST['email']) ."' limit 1;"))) { ?>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_desired_password', 'Desired Password'); ?></label>
              <?php echo functions::form_draw_password_field('password', '', 'required="required"'); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_confirm_password', 'Confirm Password'); ?></label>
              <?php echo functions::form_draw_password_field('confirmed_password', '', 'required="required"'); ?>
            </div>
          </div>
        </div>
        <?php //} ?>
        <?php //} ?>
      </div>
    </div>

    <p><button class="btn btn-block btn-default" name="save_customer_details" type="submit" disabled="disabled"><?php echo language::translate('title_save_changes', 'Save Changes'); ?></button></p>
  </div>
</div>

<script>

// Toggles

  $('#checkout-customer').on('click', 'input[name="different_shipping_address"]', function(e){
    if (this.checked == true) {
      $('#shipping-address-container').slideDown('fast');
    } else {
      $('#shipping-address-container').slideUp('fast');
    }
  });

  $('#checkout-customer').on('click', 'input[name="create_account"]', function(){
    if (this.checked == true) {
      $('#account-container').slideDown('fast');
    } else {
      $('#account-container').slideUp('fast');
    }
  });

// Get Address

  $(".billing-address :input").change(function() {
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

// Chained Select

  $("select[name='country_code']").change(function(){
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

  $("select[name='shipping_address[country_code]']").change(function(){
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

// Checksum

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
            $('#checkout-customer button[name="save_customer_details"]').trigger('click');
          }
        }
      }, 50
    );
  });

  $('body').on('focusin', '#checkout-customer', function() {
    clearTimeout(timerSubmitCustomer);
  });

// Initiate

  if ($("select[name='country_code']").find('option:selected').data('tax-id-format') != '') {
    $("select[name='country_code']").closest('table').find("input[name='tax_id']").attr('pattern', $("select[name='country_code']").find('option:selected').data('tax-id-format'));
  } else {
    $("select[name='country_code']").closest('table').find("input[name='tax_id']").removeAttr('pattern');
  }

  if ($("select[name='country_code']").find('option:selected').data('postcode-format') != '') {
    $("select[name='country_code']").closest('table').find("input[name='postcode']").attr('pattern', $("select[name='country_code']").find('option:selected').data('postcode-format'));
    $("select[name='country_code']").closest('table').find("input[name='postcode']").attr('required', 'required');
    $("select[name='country_code']").closest('table').find("input[name='postcode']").closest('td').find('.required').show();
  } else {
    $("select[name='country_code']").closest('table').find("input[name='postcode']").removeAttr('pattern');
    $("select[name='country_code']").closest('table').find("input[name='postcode']").removeAttr('required');
    $("select[name='country_code']").closest('table').find("input[name='postcode']").closest('td').find('.required').hide();
  }

  if ($("select[name='country_code']").find('option:selected').data('phone-code') != '') {
    $("select[name='country_code']").closest('table').find("input[name='phone']").attr('placeholder', '+' + $("select[name='country_code']").find('option:selected').data('phone-code'));
  } else {
    $("select[name='country_code']").closest('table').find("input[name='phone']").removeAttr('placeholder');
  }

  if ($("select[name='zone_code'] option").length == 0) $("select[name='zone_code']").closest('td').css('opacity', 0.15);

  if ($("select[name='shipping_address[country_code]']").find('option:selected').data('postcode-format') != '') {
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").attr('pattern', $("select[name='shipping_address[country_code]']").find('option:selected').data('postcode-format'));
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").attr('required', 'required');
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").closest('td').find('.required').show();
  } else {
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").removeAttr('pattern');
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").removeAttr('required');
    $("select[name='shipping_address[country_code]']").closest('table').find("input[name='shipping_address[postcode]']").closest('td').find('.required').hide();
  }

  if ($("select[name='shipping_address[zone_code]'] option").length == 0) $("select[name='shipping_address[zone_code]']").closest('td').css('opacity', 0.15);
</script>