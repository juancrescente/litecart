<div style="float: right;"><?php echo functions::form_draw_link_button(document::link('', array('app' => $_GET['app'], 'doc' => 'edit_warehouse')), language::translate('title_add_new_warehouse', 'Add New Warehouse'), '', 'add'); ?></div>
<h1 style="margin-top: 0px;"><?php echo $app_icon; ?> <?php echo language::translate('title_warehouses', 'Warehouses'); ?></h1>

<?php echo functions::form_draw_form_begin('warehouses_form', 'post'); ?>
<table class="dataTable" width="100%">
  <tr class="header">
    <th><?php echo functions::draw_fonticon('fa-check-square-o fa-fw checkbox-toggle'); ?></th>
    <th><?php echo language::translate('title_id', 'ID'); ?></th>
    <th width="100%"><?php echo language::translate('title_name', 'Name'); ?></th>
    <th></th>
    <th>&nbsp;</th>
  </tr>
<?php
    $warehouses_query = database::query(
      "select id, name from ". DB_TABLE_WAREHOUSES ."
      order by name asc;"
    );

    if (database::num_rows($warehouses_query) > 0) {
      while ($warehouse = database::fetch($warehouses_query)) {
?>
  <tr class="row">
    <td><?php echo functions::form_draw_checkbox('warehouses['. $warehouse['id'] .']', $warehouse['id']); ?></td>
    <td><?php echo $warehouse['id']; ?></td>
    <td><a href="<?php echo document::href_link('', array('doc' => 'edit_warehouse', 'warehouse_id' => $warehouse['id']), array('app')); ?>"><?php echo $warehouse['name']; ?></a></td>
    <td style="text-align: center;"><?php echo ($warehouse['id'] == settings::get('default_warehouse_id')) ? '<strong>'. language::translate('title_default') : '</strong>'; ?></td>
    <td><a href="<?php echo document::href_link('', array('app' => $_GET['app'], 'doc' => 'edit_warehouse', 'warehouse_id' => $warehouse['id'])); ?>" title="<?php echo language::translate('title_edit', 'Edit'); ?>"><?php echo functions::draw_fonticon('fa-pencil'); ?></a></td>
  </tr>
<?php
      }
    }
?>
  <tr class="footer">
    <td colspan="5"><?php echo language::translate('title_warehouses', 'Warehouses'); ?>: <?php echo database::num_rows($warehouses_query); ?></td>
  </tr>
</table>

<script>
  $(".dataTable .checkbox-toggle").click(function() {
    $(this).closest("form").find(":checkbox").each(function() {
      $(this).attr('checked', !$(this).attr('checked'));
    });
    $(".dataTable .checkbox-toggle").attr("checked", true);
  });

  $('.dataTable tr').click(function(event) {
    if ($(event.target).is('input:checkbox')) return;
    if ($(event.target).is('a, a *')) return;
    if ($(event.target).is('th')) return;
    $(this).find('input:checkbox').trigger('click');
  });
</script>

<?php echo functions::form_draw_form_end(); ?>