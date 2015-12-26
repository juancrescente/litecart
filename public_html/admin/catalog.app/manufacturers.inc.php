<?php
  if (!empty($_POST['enable']) || !empty($_POST['disable'])) {
  
    if (!empty($_POST['manufacturers'])) {
      foreach ($_POST['manufacturers'] as $key => $value) $_POST['manufacturers'][$key] = database::input($value);
      database::query(
        "update ". DB_TABLE_MANUFACTURERS ."
        set status = '". ((!empty($_POST['enable'])) ? 1 : 0) ."'
        where id in ('". implode("', '", $_POST['manufacturers']) ."');"
      );
    }
    
    header('Location: '. document::link());
    exit;
  }
?>
<ul class="list-inline pull-right">
  <li><?php echo functions::form_draw_link_button(document::link('', array('app' => $_GET['app'], 'doc' => 'edit_manufacturer')), language::translate('title_add_new_manufacturer', 'Add New Manufacturer'), '', 'add'); ?></li>
</ul>

<h1 style="margin-top: 0px;"><?php echo $app_icon; ?> <?php echo language::translate('title_manufacturers', 'Manufacturers'); ?></h1>

<?php echo functions::form_draw_form_begin('manufacturers_form', 'post'); ?>

  <table class="table table-striped data-table">
    <thead>
      <tr>
        <th><?php echo functions::form_draw_checkbox('checkbox_toggle', '', ''); ?></th>
        <th>&nbsp;</th>
        <th class="main"><?php echo language::translate('title_name', 'Name'); ?></th>
        <th><?php echo language::translate('title_products', 'Products'); ?></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
<?php
    $manufacturers_query = database::query(
      "select * from ". DB_TABLE_MANUFACTURERS ."
      order by name asc;"
    );
    
    if (database::num_rows($manufacturers_query) > 0) {
      while ($manufacturer = database::fetch($manufacturers_query)) {
        $num_active = database::num_rows(database::query("select id from ". DB_TABLE_PRODUCTS ." where status and manufacturer_id = ". (int)$manufacturer['id'] .";"));
        $num_products = database::num_rows(database::query("select id from ". DB_TABLE_PRODUCTS ." where manufacturer_id = ". (int)$manufacturer['id'] .";"));
?>
      <tr class="<?php echo empty($manufacturer['status']) ? 'semi-transparent' : null; ?>">
        <td><?php echo functions::form_draw_checkbox('manufacturers['. $manufacturer['id'] .']', $manufacturer['id']); ?></td>
        <td><?php echo functions::draw_fonticon('fa-circle', 'style="color: '. (!empty($manufacturer['status']) ? '#99cc66' : '#ff6666') .';"'); ?></td>
        <td><img src="<?php echo (($manufacturer['image']) ? functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $manufacturer['image'], 16, 16, 'FIT_USE_WHITESPACING') : WS_DIR_IMAGES .'no_image.png'); ?>" width="16" height="16" align="absbottom" /> <a href="<?php echo document::href_link('', array('doc' => 'edit_manufacturer', 'manufacturer_id' => $manufacturer['id']), array('app')); ?>"><?php echo $manufacturer['name']; ?></a></td>
        <td class="text-center"><?php echo (int)$num_active .' ('. (int)$num_products .')'; ?></td>
        <td class="text-right"><a href="<?php echo document::href_link('', array('app' => $_GET['app'], 'doc' => 'edit_manufacturer', 'manufacturer_id' => $manufacturer['id'])); ?>" title="<?php echo language::translate('title_edit', 'Edit'); ?>"><?php echo functions::draw_fonticon('fa-pencil'); ?></a></td>
      </tr>
<?php
      }
    }
?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5"><?php echo language::translate('title_manufacturers', 'Manufacturers'); ?>: <?php echo database::num_rows($manufacturers_query); ?></td>
      </tr>
    </tfoot>
  </table>

  <script>
    $(".data-table input[name='checkbox_toggle']").click(function() {
      $(this).closest("form").find(":checkbox").each(function() {
        $(this).attr('checked', !$(this).attr('checked'));
      });
      $(".data-table input[name='checkbox_toggle']").attr("checked", true);
    });

    $('.data-table tr').click(function(event) {
      if ($(event.target).is('input:checkbox')) return;
      if ($(event.target).is('a, a *')) return;
      if ($(event.target).is('th')) return;
      $(this).find('input:checkbox').trigger('click');
    });
  </script>

  <p><span class="button-set"><?php echo functions::form_draw_button('enable', language::translate('title_enable', 'Enable'), 'submit', '', 'on'); ?> <?php echo functions::form_draw_button('disable', language::translate('title_disable', 'Disable'), 'submit', '', 'off'); ?></span></p>

<?php echo functions::form_draw_form_end(); ?>