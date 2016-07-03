<?php
  if (empty(document::$settings['cookie_acceptance'])) return;
  if (!empty($_COOKIE['cookies_accepted'])) return;

  if (!isset(document::$snippets['bottom'])) document::$snippets['bottom'] = '';

  document::$snippets['foot_tags']['jquery-cookie'] = '<script src="'. WS_DIR_EXT .'jquery/jquery.cookie.min.js"></script>';

  document::$snippets['javascript'][] = '  $("button[name=\'accept_cookies\']").click(function(){' . PHP_EOL
                                      . '    $("#cookies-acceptance").fadeOut();' . PHP_EOL
                                      . '    $.cookie("cookies_accepted", "1", {path: "'. WS_DIR_HTTP_HOME .'", expires: 365});' . PHP_EOL
                                      . '  });';
?>
<div id="cookies-acceptance" class="text-center">
  <?php echo language::translate('terms_cookies_acceptance', 'We rely on cookies to provide our services. By using our services, you agree to our use of cookies.'); ?> <?php echo functions::form_draw_button('accept_cookies', language::translate('title_ok', 'OK'), 'button'); ?>
</div>
