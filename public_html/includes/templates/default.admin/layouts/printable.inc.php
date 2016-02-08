<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<link rel="stylesheet" href="{snippet:template_path}styles/bootstrap.css" />
<link rel="stylesheet" href="{snippet:template_path}styles/bootstrap-theme.css" />
<link rel="stylesheet" href="{snippet:template_path}styles/app.css" />
<link rel="stylesheet" href="{snippet:template_path}styles/printable.css" />
<!--snippet:head_tags-->
<?php if (isset($_GET['media']) && $_GET['media'] == 'print') { ?><script>window.onload=function(){window.print();}</script><?php } ?>
</head>
<body>

<!--snippet:content-->

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>