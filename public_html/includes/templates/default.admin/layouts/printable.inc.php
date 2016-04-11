<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo WS_DIR_TEMPLATES; ?>default.catalog/css/bootstrap/theme.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.min.css" />
<link rel="stylesheet" href="{snippet:template_path}css/printable.min.css" />
<!--snippet:head_tags-->
<?php if (isset($_GET['media']) && $_GET['media'] == 'print') { ?><script>window.onload=function(){window.print();}</script><?php } ?>
</head>
<body>

<!--snippet:content-->

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>