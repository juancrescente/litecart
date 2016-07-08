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

  <div id="top-menu" class="row">
    <div class="customer-service hidden-xs hidden-sm col-md-4"><?php echo functions::draw_fonticon('fa-phone'); ?> <a href="tel://<?php echo settings::get('store_phone'); ?>"><?php echo settings::get('store_phone'); ?></a></div>
    <div class="region col-md-8 text-right">
      <ul class="list-inline">
        <li class="language"><?php echo language::$selected['name']; ?></li>
        <li class="currency"><span title="<?php echo currency::$selected['name']; ?>"><?php echo currency::$selected['code']; ?></span></li>
        <li class="country"><img src="<?php echo WS_DIR_IMAGES .'countries/'. strtolower(customer::$data['country_code']) .'.png'; ?>" alt="<?php echo functions::reference_get_country_name(customer::$data['country_code']); ?>" title="<?php echo functions::reference_get_country_name(customer::$data['country_code']); ?>" style="vertical-align: baseline;" /></li>
        <li class="change"><a href="<?php echo document::href_ilink('regional_settings'); ?>" data-toggle="lightbox"><?php echo language::translate('title_change', 'Change'); ?></a></li>
      </ul>
    </div>
  </div>

  <header id="header">
    <a class="logotype hidden-xs" href="<?php echo document::ilink(''); ?>">
      <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-height: 4em;" />
    </a>

    <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
  </header>

  <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_menu.inc.php'); ?>

  <!--snippet:content-->

  <!--snippet:bottom-->

  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_site_footer.inc.php'); ?>

  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATE . 'views/cookie_notice.inc.php'); ?>
</div>

<!--snippet:foot_tags-->
<!--snippet:javascript-->
<script src="{snippet:template_path}js/app.min.js"></script>
<script>
// Add to cart animation
  $('body').on('submit', 'form[name="buy_now_form"]', function(e) {
    e.preventDefault();
    var form = $(this);
    $(this).find('button[name="add_cart_product"]').animate_from_to('#cart', {
      pixels_per_second: 2000,
      initial_css: {
        'border': '2px rgba(0,136,204,1) solid',
        'background-color': 'rgba(0,136,204,0.5)',
        'z-index': '999999',
        'border-radius': '3px',
        'padding': '5px',
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
</body>
</html>