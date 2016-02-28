<?php

  if (!empty($_GET['warehouse_id'])) {
    $warehouse = new ctrl_warehouse($_GET['warehouse_id']);
  } else {
    $warehouse = new ctrl_warehouse();
  }

  if (empty($_POST)) {
    foreach ($warehouse->data as $key => $value) {
      $_POST[$key] = $value;
    }
  }

  breadcrumbs::add(!empty($warehouse->data['id']) ? language::translate('title_edit_warehouse', 'Edit Warehouse') : language::translate('title_add_new_warehouse', 'Add New Warehouse'));

  if (isset($_POST['save'])) {

    if (empty($_POST['name'])) notices::add('errors', language::translate('error_name_missing', 'You must enter a name.'));

    if (empty(notices::$data['errors'])) {

      if (!isset($_POST['status'])) $_POST['status'] = '0';

      $fields = array(
        'name',
        'description',
        'email',
        'phone',
        'link',
      );

      foreach ($fields as $field) {
        if (isset($_POST[$field])) $warehouse->data[$field] = $_POST[$field];
      }

      $warehouse->save();

      if (!empty($_POST['set_default'])) {
        database::query("update ". DB_TABLE_SETTINGS ." set `value` = '". (int)$warehouse->data['id'] ."' where `key` = 'default_warehouse_id' limit 1;");
      }

      notices::add('success', language::translate('success_changes_saved', 'Changes saved'));
      header('Location: '. document::link('', array('doc' => 'warehouses'), array('app')));
      exit;
    }
  }

  if (isset($_POST['delete']) && $warehouse) {

    if ($warehouse->data['id'] == settings::get('default_warehouse_id')) {
      notices::add('errors', language::translate('error_cannot_delete_default_warehouse', 'You must change the default warehouse before it can be deleted.'));
    }

    $warehouse->delete();

    notices::add('success', language::translate('success_post_deleted', 'Post deleted'));
    header('Location: '. document::link('', array('doc' => 'warehouses'), array('app')));
    exit;
  }

?>
<h1 style="margin-top: 0px;"><?php echo $app_icon; ?> <?php echo !empty($warehouse->data['id']) ? language::translate('title_edit_warehouse', 'Edit Warehouse') : language::translate('title_add_new_warehouse', 'Add New Warehouse'); ?></h1>

<?php echo functions::form_draw_form_begin(false, 'post', false, true); ?>

  <table>
    <tr>
      <td>
        <strong><?php echo language::translate('title_name', 'Name'); ?></strong><br />
          <?php echo functions::form_draw_text_field('name', true); ?>
      </td>
    </tr>
    <tr>
      <td>
        <strong><?php echo language::translate('title_description', 'description'); ?></strong><br />
          <?php echo functions::form_draw_textarea('description', true, 'data-size="large"'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <strong><?php echo language::translate('title_address', 'address'); ?></strong><br />
          <?php echo functions::form_draw_textarea('address', true, 'data-size="medium"'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <strong><?php echo language::translate('title_email_address', 'Email Address'); ?></strong><br />
          <?php echo functions::form_draw_email_field('email', true, 'email', ''); ?>
      </td>
    </tr>
    <tr>
      <td>
        <strong><?php echo language::translate('title_phone', 'Phone'); ?></strong><br />
          <?php echo functions::form_draw_text_field('phone', true); ?>
      </td>
    </tr>
    <tr>
      <td>
        <label><?php echo functions::form_draw_checkbox('set_default', '1', (!empty($warehouse->data['id']) && $warehouse->data['id'] == settings::get('default_warehouse_id')) ? '1' : true); ?> <?php echo language::translate('text_set_as_default_warehouse', 'Set as default warehouse'); ?></label>
      </td>
    </tr>
  </table>

  <p><span class="button-set"><?php echo functions::form_draw_button('save', language::translate('title_save', 'Save'), 'submit', '', 'save'); ?> <?php echo functions::form_draw_button('cancel', language::translate('title_cancel', 'Cancel'), 'button', 'onclick="history.go(-1);"', 'cancel'); ?> <?php echo (isset($warehouse->data['id'])) ? functions::form_draw_button('delete', language::translate('title_delete', 'Delete'), 'submit', 'onclick="if (!confirm(\''. language::translate('text_are_you_sure', 'Are you sure?') .'\')) return false;"', 'delete') : false; ?></span></p>

<?php echo functions::form_draw_form_end(); ?>