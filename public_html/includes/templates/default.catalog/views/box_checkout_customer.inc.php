<div id="checkout-customer">
  <h2 class="title"><?php echo language::translate('title_customer_details', 'Customer Details'); ?></h2>
  
  <?php echo functions::form_draw_form_begin('customer_form', 'post', false, false); ?>
  
    <div class="row">
    
      <div class="billing-address col-md-6">
      
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_tax_id', 'Tax ID'); ?></label>
                <?php echo functions::form_draw_text_field('tax_id', true); ?>
            </div>
          </div>
          
          <div class="col-md-6">    
            <div class="form-group">
              <label><?php echo language::translate('title_company', 'Company'); ?></label>
                <?php echo functions::form_draw_text_field('company', true); ?>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">  
            <div class="form-group">
              <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
                <?php echo functions::form_draw_text_field('firstname', true, 'required="required"'); ?>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
                <?php echo functions::form_draw_text_field('lastname', true, 'required="required"'); ?>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
                <?php echo functions::form_draw_text_field('address1', true, 'required="required"'); ?>
            </div>
          </div>
          
          <div class="col-md-6">   
            <div class="form-group">
              <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
              <?php echo functions::form_draw_text_field('address2', true); ?>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
                <?php echo functions::form_draw_text_field('postcode', true); ?>
            </div>
          </div>
          
          <div class="col-md-6">   
            <div class="form-group">
              <label><?php echo language::translate('title_city', 'City'); ?></label>
                <?php echo functions::form_draw_text_field('city', true); ?>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_country', 'Country'); ?></label>
                <?php echo functions::form_draw_countries_list('country_code', true); ?>
            </div>
          </div>
          
          <div class="col-md-6">   
            <div class="form-group">
              <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
                <?php echo form_draw_zones_list(isset($_POST['country_code']) ? $_POST['country_code'] : '', 'zone_code', true); ?>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_email', 'Email'); ?></label>
                <?php echo functions::form_draw_email_field('email', true, 'required="required"'. (!empty(customer::$data['id']) ? ' readonly="readonly"' : '')); ?>
            </div>
          </div>
          
          <div class="col-md-6">   
            <div class="form-group">
              <label><?php echo language::translate('title_phone', 'Phone'); ?></label>
                <?php echo functions::form_draw_phone_field('phone', true, 'required="required"'); ?>
            </div>
          </div>
        </div>

        <?php if (empty(customer::$data['id']) && settings::get('register_guests') && settings::get('fields_customer_password')) { ?>
        <?php if (empty($_POST['email']) || !database::num_rows(database::query("select id from ". DB_TABLE_CUSTOMERS ." where email = '". database::input($_POST['email']) ."' limit 1;"))) { ?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo language::translate('title_desired_password', 'Desired Password'); ?></label>
              <?php echo functions::form_draw_password_field('password', '', 'required="required"'); ?>
            </div>
          </div>
          
          <div class="col-md-6">   
            <div class="form-group">
              <label><?php echo language::translate('title_confirm_password', 'Confirm Password'); ?></label>
              <?php echo functions::form_draw_password_field('confirmed_password', '', 'required="required"'); ?>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
        
        <?php echo functions::form_draw_button('set_addresses', language::translate('title_save_changes', 'Save Changes'), 'submit', 'disabled="disabled"'); ?>
      </div>
    
      <div class="shipping-address col-md-6">
        
        <h3><?php echo functions::form_draw_checkbox('different_shipping_address', '1', empty($_POST['different_shipping_address']) ? '' : '1', 'style="margin: 0px;" onclick="if (this.checked == true) $(\'#shipping-address-container\').slideDown(); else $(\'#shipping-address-container\').slideUp();"'); ?> <?php echo language::translate('title_different_shipping_address', 'Different Shipping Address'); ?></h3>
          
        <div id="shipping-address-container"<?php echo (empty($_POST['different_shipping_address'])) ? ' style="display: none;"' : false; ?>>
        
          <div class="row">
            <div class="col-md-6">    
              <div class="form-group">
                <label><?php echo language::translate('title_company', 'Company'); ?></label>
                  <?php echo functions::form_draw_text_field('company', true); ?>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">  
              <div class="form-group">
                <label><?php echo language::translate('title_firstname', 'First Name'); ?></label>
                  <?php echo functions::form_draw_text_field('firstname', true, 'required="required"'); ?>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label><?php echo language::translate('title_lastname', 'Last Name'); ?></label>
                  <?php echo functions::form_draw_text_field('lastname', true, 'required="required"'); ?>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><?php echo language::translate('title_address1', 'Address 1'); ?></label>
                  <?php echo functions::form_draw_text_field('address1', true, 'required="required"'); ?>
              </div>
            </div>
            
            <div class="col-md-6">   
              <div class="form-group">
                <label><?php echo language::translate('title_address2', 'Address 2'); ?></label>
                <?php echo functions::form_draw_text_field('address2', true); ?>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><?php echo language::translate('title_postcode', 'Postcode'); ?></label>
                  <?php echo functions::form_draw_text_field('postcode', true); ?>
              </div>
            </div>
            
            <div class="col-md-6">   
              <div class="form-group">
                <label><?php echo language::translate('title_city', 'City'); ?></label>
                  <?php echo functions::form_draw_text_field('city', true); ?>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><?php echo language::translate('title_country', 'Country'); ?></label>
                  <?php echo functions::form_draw_countries_list('country_code', true); ?>
              </div>
            </div>
            
            <div class="col-md-6">   
              <div class="form-group">
                <label><?php echo language::translate('title_zone_state_province', 'Zone/State/Province'); ?></label>
                  <?php echo form_draw_zones_list(isset($_POST['country_code']) ? $_POST['country_code'] : '', 'zone_code', true); ?>
              </div>
            </div>
          </div>
        
          <?php echo functions::form_draw_button('set_addresses', language::translate('title_save_changes', 'Save Changes'), 'submit', 'disabled="disabled"'); ?>
        </div>
      </div>
    </div>
  <?php echo functions::form_draw_form_end(); ?>
</div>

<script>
  $("#box-checkout-customer .billing-address input, #box-checkout-customer .billing-address select").change(function() {
    if ($(this).val() == '') return;
    if (console) console.log('Retrieving address ["'+ $(this).attr('name') +']');
    $.ajax({
      url: '<?php echo document::ilink('ajax/get_address.json'); ?>?trigger='+$(this).attr('name'),
      type: 'post',
      data: $(this).closest('form').serialize(),
      cache: false,
      async: false,
      dataType: 'json',
      error: function(jqXHR, textStatus, errorThrown) {
        if (console) console.warn(errorThrown.message);
      },
      success: function(data) {
        if (data['alert']) {
          alert(data['alert']);
        }
        $.each(data, function(key, value) {
          if (console) console.log('  ' + key +": "+ value);
          if ($("#box-checkout-customer .billing-address *[name='"+key+"']").length && $("#box-checkout-customer .billing-address *[name='"+key+"']").val() == '') {
            $("#box-checkout-customer .billing-address *[name='"+key+"']").val(value);
          }
        });
      },
    });
  });
  
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
  
  if ($("select[name='shipping_address[zone_code]'] option").length == 0) $("select[name='shipping_address[zone_code]']").closest('td').css('opacity', 0.15);
</script>