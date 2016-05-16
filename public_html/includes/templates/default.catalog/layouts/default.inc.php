<?php
// Cookie acceptance - By EU law
  if (!empty(document::$settings['cookie_acceptance'])) {
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

<div id="page" class="shadow">

  <div id="top-menu">
    <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_region.inc.php'); ?>
  </div>

  <header id="header">
    <a class="hidden-xs" href="<?php echo document::ilink(''); ?>">
      <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-height: 4em;" />
    </a>

    <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
  </header>

  <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_menu.inc.php'); ?>

  <!--snippet:content-->

  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_footer.inc.php'); ?>
</div>

<script src="{snippet:template_path}js/app.js"></script>
<script>
// Add to cart animation
  $('body').on('submit', 'form[name="buy_now_form"]', function(e) {
    e.preventDefault();
    var form = $(this);
    $(this).find('button[name="add_cart_product"]').animate_from_to('#cart', {
      initial_css: {
        'border': '1px rgba(0,136,204,1) solid',
        'background-color': 'rgba(0,136,204,0.5)',
        'z-index': '999999',
      },
      callback: function() {
        $('*').css('cursor', 'wait');
        $.ajax({
          type: 'post',
          url: '<?php echo document::ilink('ajax/cart.json'); ?>',
          data: $(form).serialize() + '&add_cart_product=true',
          cache: false,
          async: true,
          dataType: 'json',
          beforeSend: function(jqXHR) {
            jqXHR.overrideMimeType('text/html;charset=<?php echo language::$selected['charset']; ?>');
          },
          error: function(jqXHR, textStatus, errorThrown) {
            if (console) {
              console.log('Failed adding item to cart');
              console.debug(jqXHR);
            }
            alert("Error while adding item to cart");
          },
          success: function(data) {
            if (data['alert']) alert(data['alert']);
            $('#cart .items').html('');
            console.log(data['items']);
            $.each(data['items'], function(i, item){
              $('#cart .items').append('<li><a href="'+ item.link +'">'+ item.quantity +' x '+ item.name +' - '+ item.formatted_price +'</a></li>');
            });

            $('#cart .quantity').html(data['quantity']);
            $('#cart .formatted_value').html(data['formatted_value']);
            if (data['quantity'] > 0) {
              $('#cart img').attr('src', '{snippet:template_path}images/cart_filled.png');
            } else {
              $('#cart img').attr('src', '{snippet:template_path}images/cart.png');
            }
          },
          complete: function() {
            $('*').css('cursor', '');
          }
        });
      }
    });
  });
</script>
<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>