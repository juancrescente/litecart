<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<meta name="robots" content="noindex, nofollow" />
<!--snippet:head_tags-->
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/theme.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.min.css" />
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

<!--snippet:content-->

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>