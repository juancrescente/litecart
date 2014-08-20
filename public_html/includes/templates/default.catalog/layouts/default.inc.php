<?php
// Cookie acceptance - By EU law
  if (empty($_COOKIE['cookies_accepted'])) {
    if (!isset(document::$snippets['top'])) document::$snippets['top'] = '';
    document::$snippets['top'] =  '<div id="cookies-acceptance-wrapper">' . PHP_EOL
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
                                . '</script>'
                                . document::$snippets['top'];
  }
?>
<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="keywords" content="{snippet:keywords}" />
<meta name="description" content="{snippet:description}" />
<meta name="viewport" content="width=1024">
<link rel="shortcut icon" href="<?php echo WS_DIR_HTTP_HOME; ?>favicon.ico">
<link rel="stylesheet" href="{snippet:template_path}styles/loader.css" media="all" />
<link rel="stylesheet" href="{snippet:template_path}styles/theme.css" media="all" />
<!--[if IE]><link rel="stylesheet" href="{snippet:template_path}styles/ie.css" /><![endif]-->
<!--[if IE 9]><link rel="stylesheet" href="{snippet:template_path}styles/ie9.css" /><![endif]-->
<!--[if lt IE 9]><link rel="stylesheet" href="{snippet:template_path}styles/ie8.css" /><![endif]-->
<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--snippet:head_tags-->
<!--snippet:javascript-->
<script>
  if (/iphone|ipod|android|blackberry|opera mini|opera mobi|skyfire|maemo|windows phone|palm|iemobile|symbian|symbianos|fennec/i.test(navigator.userAgent.toLowerCase())) {
    $("meta[name='viewport']").attr("content", "width=320");
  }
</script>
<style>
<?php
  $settings = unserialize(settings::get('store_template_catalog_settings'));
  
  if (!empty($settings['fixed_header'])) {
    echo '#header-wrapper { position: fixed !important; }' . PHP_EOL;
  } else {
    echo '#header-wrapper { position: absolute !important; box-shadow: none !important; background: none; }' . PHP_EOL;
    echo '#page-wrapper { padding-top: 80px; }' . PHP_EOL;
  }
?>
</style>
</head>
<body>


<div id="header-wrapper" class="shadow">
  <div style="padding: 0px 10px;">
    <header id="header" class="twelve-eighty">
    
      <div id="logotype-wrapper">
        <a href="<?php echo document::href_ilink(''); ?>"><img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" height="50" alt="<?php echo settings::get('store_name'); ?>" title="<?php echo settings::get('store_name'); ?>" /></a>
      </div>
      
      <div id="site-links-wrapper">
      <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_links.inc.php'); ?>
      </div>
      
      <div id="region-wrapper">
        <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_region.inc.php'); ?>
      </div>
      
      <?php if (!settings::get('catalog_only_mode')) { ?>
      <div id="cart-wrapper">
        <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
      </div>
      <?php } ?>
      
    </header>
  </div>
</div>

<div id="page-wrapper">
  <div id="page">
    
    <div id="site-menu-wrapper">
      <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_menu.inc.php'); ?>
    </div>
    
    <div id="main-wrapper" class="twelve-eighty">
      <div id="main">
      
        <div class="top">
          <!--snippet:notices-->
          <!--snippet:top-->
        </div>
        
        <div class="middle">
          
          <div class="left">
            <!--snippet:column_left-->
          </div>
          
          <div class="content">
            <!--snippet:content-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="footer-wrapper">
  <footer id="footer" class="twelve-eighty">
    
    <div id="breadcrumbs-wrapper">
      <!--snippet:breadcrumbs-->
    </div>

    <table>
      <tr>
        <td class="categories">
          <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_footer_categories.inc.php'); ?>
        </td>
        <td class="manufacturers">
          <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_footer_manufacturers.inc.php'); ?>
        </td>
        <td class="account">
          <nav>
            <h4><?php echo language::translate('title_account', 'Account'); ?></h4>
            <ul class="list-vertical">
              <li><a href="<?php echo document::href_ilink('select_region'); ?>"><?php echo language::translate('title_select_region', 'Select Region'); ?></a></li>
              <?php if (empty(customer::$data['id'])) { ?>
              <li><a href="<?php echo document::href_ilink('create_account'); ?>"><?php echo language::translate('title_create_account', 'Create Account'); ?></a></li>
              <li><a href="<?php echo document::href_ilink('login'); ?>"><?php echo language::translate('title_login', 'Login'); ?></a></li>
              <?php } else { ?>
              <li><a href="<?php echo document::href_ilink('order_history'); ?>"><?php echo language::translate('title_order_history', 'Order History'); ?></a></li>
              <li><a href="<?php echo document::href_ilink('edit_account'); ?>"><?php echo language::translate('title_edit_account', 'Edit Account'); ?></a></li>
              <li><a href="javascript:logout();"><?php echo language::translate('title_logout', 'Logout'); ?></a></li>
              <script>
                function logout() {
                  var form = $('<?php
                    echo str_replace(array("\r", "\n"), '', functions::form_draw_form_begin('logout_form', 'post')
                                                          . functions::form_draw_hidden_field('logout', 'true')
                                                          . functions::form_draw_form_end()
                    );
                  ?>');
                  $(document.body).append(form);
                  form.submit();
                }
              </script>
              <?php } ?>
            </ul>
          </nav>
        </td>
        <td class="information">
          <?php include vqmod::modcheck(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_footer_information.inc.php'); ?>
        </td>
        <td class="contact">
          <h4><?php echo language::translate('title_contact', 'Contact'); ?></h4>
          <p><?php echo nl2br(settings::get('store_postal_address')); ?></p><br />
          <p><?php echo settings::get('store_phone'); ?><br />
          <?php list($account, $domain) = explode('@', settings::get('store_email')); echo "<script>document.write('". $account ."' + '@' + '". $domain ."');</script>"; ?></p>
        </td>
      </tr>
    </table>
  </footer>
  
  <div id="copyright" class="twelve-eighty engraved-text">
    <p>Copyright &copy; <?php echo date('Y'); ?> <?php echo settings::get('store_name'); ?>. All rights reserved &middot; Powered by <a href="http://www.litecart.net" target="_blank">LiteCart</a></p>
  </div>
</div>

<a href="#" id="scroll-up">Scroll</a>
<script>
  $(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
      $('#scroll-up').fadeIn();
    } else {
      $('#scroll-up').fadeOut();
    }
  });
  
  $('#scroll-up').click(function(){
    $("html, body").animate({scrollTop: 0}, 1000, 'swing');
    return false;
  });
</script>
  
<!--snippet:foot_tags-->
</body>
</html>