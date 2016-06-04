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

  <header id="header">
    <div class="row">
      <div class="col-xs-12 col-sm-3">
        <a class="logotype" href="<?php echo document::ilink(''); ?>">
          <img src="<?php echo WS_DIR_IMAGES; ?>logotype.png" alt="<?php echo settings::get('store_name'); ?>" style="max-height: 4em;" />
        </a>
      </div>

      <div class="back-link col-xs-6 col-sm-6 text-center">
        <a class="btn btn-default" href="<?php echo document::href_ilink(''); ?>"><?php echo functions::draw_fonticon('fa-caret-left'); ?> <?php echo language::translate('title_continue_shopping', 'Continue Shopping'); ?></a>
      </div>

      <div class="customer-service text-right col-xs-6 col-sm-3">
        <h4 class="title"><?php echo language::translate('title_customer_service', 'Customer Service'); ?></h4>
        <div class="phone"><?php echo functions::draw_fonticon('fa-phone'); ?> <?php echo settings::get('store_phone'); ?></div>
      </div>
    </div>
  </header>

  <!--snippet:content-->
</div>

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>