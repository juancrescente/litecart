<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="robots" content="noindex, nofollow" />
<!--snippet:head_tags-->
<link href="{snippet:template_path}styles/app.css" rel="stylesheet" />
<link href="{snippet:template_path}styles/bootstrap-theme.css" rel="stylesheet" />
<script>
var $buoop = {c:2}; 
function $buo_f(){ 
  var e = document.createElement("script"); 
  e.src = "//browser-update.org/update.js"; 
  document.body.appendChild(e);
};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}
</script>
</head>
<body>

<div id="sidebar" class="pull-left">

  <div id="logotype">
    <a href="<?php echo document::href_link(WS_DIR_ADMIN); ?>">
      <img class="center-block img-responsive" src="<?php echo functions::image_process(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . 'logotype.png', array('width' => 220, 'height' => 70, 'clipping' => 'FIT_ONLY_BIGGER')); ?>" title="<?php echo settings::get('store_name'); ?>" />
    </a>
  </div>
  
  <div id="shortcuts" class="row text-center">
    <a href="<?php echo document::href_ilink(''); ?>" title="<?php echo language::translate('title_catalog', 'Catalog'); ?>"><?php echo functions::draw_fonticon('fa-chevron-circle-left'); ?></a>
    <a href="<?php echo document::href_link(WS_DIR_ADMIN); ?>" title="<?php echo htmlspecialchars(language::translate('title_home', 'Home')); ?>"><?php echo functions::draw_fonticon('fa-home fa-lg'); ?></a>
    <?php if (settings::get('webmail_link', '')) { ?><a href="<?php echo settings::get('webmail_link'); ?>" target="_blank" title="<?php echo language::translate('title_webmail', 'Webmail'); ?>"><?php echo functions::draw_fonticon('fa-envelope'); ?></a><?php } ?>
    <?php if (settings::get('database_admin_link', '')) { ?><a href="<?php echo settings::get('database_admin_link'); ?>" target="_blank" title="<?php echo language::translate('title_database_manager', 'Database Manager'); ?>"><?php echo functions::draw_fonticon('fa-database'); ?></a><?php } ?>
    <a href="<?php echo document::href_link(WS_DIR_ADMIN . 'logout.php'); ?>" title="<?php echo language::translate('text_logout', 'Logout'); ?>"><?php echo functions::draw_fonticon('fa-sign-out fa-lg'); ?></a>
  </div>
  
  <!--snippet:box_apps_menu-->
  
  <div id="languages" class="row text-center">
    <?php foreach (language::$languages as $language) { ?>
    <?php if ($language['status']) { ?><a href="<?php echo document::href_link(null, array('language' => $language['code']), true); ?>"><img src="<?php echo WS_DIR_IMAGES .'icons/languages/'. $language['code'] .'.png'; ?>" alt="<?php echo htmlspecialchars($language['name']); ?>" style="max-width: 16px;" /></a><?php } ?>
    <?php } ?>
  </div>
  
  <div id="platform" class="row text-center"><?php echo PLATFORM_NAME; ?> <?php echo PLATFORM_VERSION; ?></div>
  
  <div id="copyright" class="row text-center">&copy; <?php echo date('2012-Y'); ?> LiteCart<br />
    <a href="http://www.litecart.net" target="_blank">www.litecart.net</a>
  </div>
</div>

<div id="main">
  <!--snippet:content-->
</div>

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>