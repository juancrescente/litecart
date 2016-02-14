<?php
  $template_config = array(
    array(
      'key' => 'fixed_header',
      'default_value' => '0',
      'title' => language::translate('title_fixed_header', 'Fixed Header'),
      'description' => language::translate('description_fixed_header', 'Fixate the header position making it stick on top while scroll.'),
      'function' => 'toggle("y/n")',
    ),
    array(
      'key' => 'cookie_acceptance',
      'default_value' => '1',
      'title' => language::translate('title_cookie_acceptance_notice', 'Cookie Acceptance Notice'),
      'description' => language::translate('description_cookie_acceptance_notice', 'Display the cookie acceptance notice accoarding to laws in the European Union.'),
      'function' => 'toggle("y/n")',
    ),
  );
?>