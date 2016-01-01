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
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap-theme.min.css" />
<!--snippet:head_tags-->
<link rel="stylesheet" href="{snippet:template_path}css/app.css" />
<link rel="stylesheet" href="{snippet:template_path}css/theme.css" />
</head>
<body>

  <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_menu.inc.php'); ?>
  
  <div class="container">
    <div class="col-md-2">
      <div class="row">
        <!--snippet:column_left-->
          <div>
            <p class="lead"><?php echo language::translate('title_categories', 'Categories'); ?></p>
            <div class="list-group">
              <a href="#" class="list-group-item active">Category 1</a>
              <a href="#" class="list-group-item">Category 2</a>
              <a href="#" class="list-group-item">Category 3</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <!--snippet:notices-->
        <!--snippet:content-->
      </div>
  </div>  
    
  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_footer.inc.php'); ?>
  
<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>