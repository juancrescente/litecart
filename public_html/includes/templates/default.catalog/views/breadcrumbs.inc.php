<ul class="breadcrumb">
<?php
  foreach ($breadcrumbs as $breadcrumb) {
    if (!empty($breadcrumb['link'])) {
      echo '<li><a href="'. htmlspecialchars($breadcrumb['link']) .'">'. $breadcrumb['title'] .'</a></li>';
    } else {
      echo '<li>'. $separator . htmlspecialchars($breadcrumb['title']) .'</li>';
    }
  }
?>
</ul>
