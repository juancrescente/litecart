<?php
// Cookie acceptance - By EU law
  if (empty($_COOKIE['cookies_accepted'])) {
    if (!isset(document::$snippets['bottom'])) document::$snippets['bottom'] = '';
    document::$snippets['bottom'] .= '<div id="cookies-acceptance-wrapper">' . PHP_EOL
                                   . '  <div id="cookies-acceptance" class="twelve-eighty">' . PHP_EOL
                                   . '    ' . language::translate('terms_cookies_acceptance', 'We rely on cookies to provide our services. By using our services, you agree to our use of cookies.') .' '. functions::form_draw_button('accept_cookies', language::translate('title_ok', 'OK'), 'button') . PHP_EOL
                                   . '  </div>' . PHP_EOL
                                   . '</div>' . PHP_EOL
                                   . '<script src="'. WS_DIR_EXT .'jquery/jquery.cookie.min.js"></script>' . PHP_EOL
                                   . '<script>' . PHP_EOL
                                   . '  $("button[name=\'accept_cookies\']").click(function(){' . PHP_EOL
                                   . '    $("#cookies-acceptance-wrapper").fadeOut();' . PHP_EOL
                                   . '    $.cookie("cookies_accepted", "1", {path: "'. WS_DIR_HTTP_HOME .'", expires: 365});' . PHP_EOL
                                   . '  });' . PHP_EOL
                                   . '</script>';
  }
?>
<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="description" content="{snippet:description}" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--snippet:head_tags-->
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap/theme.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.min.css" />
</head>
<body id="<?php echo preg_replace('#(_|/)#', '-', route::$route['page']); ?>">

  <nav class="navbar navbar-default navbar-fixed-top shadow" role="navigation">
    <div class="twelve-eighty">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo document::ilink(''); ?>">
          <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-height: 2em;" />
        </a>
      </div>
      
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li>
            <a href="<?php echo document::href_ilink(''); ?>"><?php echo functions::draw_fonticon('fa-caret-left'); ?> <?php echo language::translate('title_continue_shopping', 'Continue Shopping'); ?></a>
          </li>
        </ul>

        <ul class="nav pull-right">
          <li>
            <h4 style="margin-bottom: 0;"><?php echo language::translate('title_customer_service', 'Customer Service'); ?></h4>
            <div class="phone"><?php echo functions::draw_fonticon('fa-phone'); ?> <?php echo settings::get('store_phone'); ?></div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!--snippet:content-->
  
<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>