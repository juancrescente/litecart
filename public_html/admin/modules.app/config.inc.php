<?php

  $app_config = array(
    'name' => language::translate('title_modules', 'Modules'),
    'default' => 'jobs',
    'theme' => array(
      'color' => '#c78dc8',
      'icon' => 'fa-cube',
    ),
    'menu' => array(
      array(
        'title' => language::translate('title_background_jobs', 'Background Jobs'),
        'doc' => 'jobs',
      ),
      array(
        'title' => language::translate('title_customer', 'Customer'),
        'doc' => 'customer',
      ),
      array(
        'title' => language::translate('title_shipping', 'Shipping'),
        'doc' => 'shipping',
      ),
      array(
        'title' => language::translate('title_payment', 'Payment'),
        'doc' => 'payment',
      ),
      array(
        'title' => language::translate('title_order_total', 'Order Total'),
        'doc' => 'order_total',
      ),
      array(
        'title' => language::translate('title_order_action', 'Order'),
        'doc' => 'order',
      ),
    ),
    'docs' => array(
      'customer' => 'modules.inc.php',
      'order_action' => 'modules.inc.php',
      'order_total' => 'modules.inc.php',
      'order_success' => 'modules.inc.php',
      'payment' => 'modules.inc.php',
      'shipping' => 'modules.inc.php',
      'jobs' => 'modules.inc.php',
      'edit_customer' => 'edit_module.inc.php',
      'edit_job' => 'edit_module.inc.php',
      'edit_order' => 'edit_module.inc.php',
      'edit_order_total' => 'edit_module.inc.php',
      'edit_payment' => 'edit_module.inc.php',
      'edit_shipping' => 'edit_module.inc.php',
      'run_job' => 'run_job.inc.php',
    ),
  );

?>