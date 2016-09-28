<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<!--snippet:head_tags-->
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/theme.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/printable.min.css" />
<!--snippet:style-->
</head>
<body>

<!--snippet:content-->

<!--snippet:foot_tags-->
<!--snippet:javascript-->
<?php if (isset($_GET['media']) && $_GET['media'] == 'print') { ?><script>window.onload=function(){window.print();}</script><?php } ?>
</body>
</html>