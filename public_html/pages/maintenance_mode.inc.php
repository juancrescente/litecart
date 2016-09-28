<?php
  document::$layout = 'maintenance';
  document::$snippets['title'][] = language::translate('title_maintenance_mode', 'Maintenance Mode');
?>
<table style="width: 100%; height: 100%;">
  <tr>
    <td style="text-align: center;">
      <?php echo functions::draw_fonticon('fa-wrench fa-3x'); ?></div>
      <h1><?php echo language::translate('title_maintenance_mode', 'Maintenance Mode'); ?></h1>
      <p><?php echo language::translate('description_maintenance_mode', 'The website is currently undergoing maintenance. We will be back shortly.'); ?></p>
    </td>
  </tr>
</table>