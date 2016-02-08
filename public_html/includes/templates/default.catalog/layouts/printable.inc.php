<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap.css" />
<link rel="stylesheet" href="{snippet:template_path}css/bootstrap-theme.css" />
<link rel="stylesheet" href="{snippet:template_path}css/app.css" />
<!--snippet:head_tags-->
<!--snippet:javascript-->
<?php if (isset($_GET['media']) && $_GET['media'] == 'print') { ?>
<script>
  window.onload = function() {
    window.print();
  }
</script>
<?php } ?>
</head>
<body>

<!--snippet:content-->

<!--snippet:foot_tags-->
</body>
</html>