<!DOCTYPE html>
<html lang="{snippet:language}">
<head>
<title>{snippet:title}</title>
<meta charset="{snippet:charset}" />
<link rel="stylesheet" href="{snippet:template_path}css/printable.min.css" />
<!--snippet:head_tags-->
</head>
<body<?php echo (isset($_GET['media']) && $_GET['media'] == 'print') ? ' onload="window.print();"' : ''; ?>>

<!--snippet:content-->

<!--snippet:foot_tags-->
<!--snippet:javascript-->
</body>
</html>