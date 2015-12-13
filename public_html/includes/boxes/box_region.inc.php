<?php
  $box_region = new view();
  $box_region->snippets = array(
    'modal_id' => functions::draw_model(),
  );
  
  echo $box_region->stitch('views/box_region');
?>
