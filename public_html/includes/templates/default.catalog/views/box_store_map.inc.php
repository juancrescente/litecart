<div id="store-map" class="curved-shadow">
  <div class="map" style="height: 400px;" class="box-shadow">
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo document::href_link('https://www.google.com/maps', array('q' => settings::get('store_visiting_address'), 'output' => 'svembed')); ?>"></iframe>
  </div>
</div>