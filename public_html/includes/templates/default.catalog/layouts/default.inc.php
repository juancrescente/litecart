<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="description" content="{snippet:description}" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap/theme.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.min.css" />
<!--snippet:head_tags-->
</head>
<body id="<?php echo preg_replace('#(_|/)#', '-', route::$route['page']); ?>">

<div id="page" class="shadow">

  <header id="header">
    <div class="row">
      <div class="hidden-xs col-sm-4 logotype">
        <a href="<?php echo document::ilink(''); ?>">
          <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-width: 250px; max-height: 60px;" />
        </a>
      </div>

      <div class="col-xs-6 col-sm-4 region text-center">
        <a href="<?php echo document::href_ilink('regional_settings'); ?>" data-toggle="lightbox">
          <ul class="list-inline">
            <li class="language"><?php echo language::$selected['name']; ?></li>
            <li class="currency"><span title="<?php echo currency::$selected['name']; ?>"><?php echo currency::$selected['code']; ?></span></li>
            <li class="country"><img src="<?php echo WS_DIR_IMAGES .'countries/'. strtolower(customer::$data['country_code']) .'.png'; ?>" alt="<?php echo reference::country(customer::$data['country_code'])->name; ?>" title="<?php echo reference::country(customer::$data['country_code'])->name; ?>" style="vertical-align: baseline;" /></li>
          </ul>
        </a>
      </div>

      <div class="col-xs-6 col-sm-4 cart">
        <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_cart.inc.php'); ?>
      </div>
    </div>

  </header>

  <?php include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'site_menu.inc.php'); ?>

  <!--snippet:content-->

  <!--snippet:bottom-->

  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'site_footer.inc.php'); ?>

  <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATE . 'views/site_cookie_notice.inc.php'); ?>
</div>

<!--snippet:foot_tags-->
<script src="{snippet:template_path}js/app.min.js"></script>
<!--snippet:javascript-->
</body>
</html>