<div id="checkout-customer" class="panel panel-default">
  <div class="panel-heading">
    <h2 class="panel-title title"><?php echo language::translate('title_customer_details', 'Customer Details'); ?></h2>
  </div>

  <div class="panel-body">

    <?php if (empty(customer::$data['id'])) { ?>
    <ul class="nav nav-tabs" style="margin-bottom: 1em;">
      <li class="active"><a href="#tab-guests"><?php echo language::translate('title_guest', 'Guest'); ?></a></li>
      <li><a href="<?php echo document::ilink('login') ?>"><?php echo language::translate('title_sign_in', 'Sign In'); ?></a></li>
    </ul>
    <?php } ?>

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
              <?php echo functions::form_draw_password_field('password', ''); ?>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label><?php echo language::translate('title_confirm_password', 'Confirm Password'); ?></label>
              <?php echo functions::form_draw_password_field('confirmed_password', ''); ?>
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
  <?php if (!empty(notices::$data['errors'])) { ?>
  alert("<?php echo functions::general_escape_js(notices::$data['errors'][0]); notices::$data['errors'] = array(); ?>");
  <?php } ?>
  
  var customer_form_changed = false;
  var customer_form_checksum = $('#checkout-customer :input').serialize();

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