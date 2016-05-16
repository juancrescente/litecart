<div id="region">
  <ul class="list-inline">
    <li class="language"><?php echo language::$selected['name']; ?></li>
    <li class="currency"><span title="<?php echo currency::$selected['name']; ?>"><?php echo currency::$selected['code']; ?></span></li>
    <li class="country"><img src="<?php echo WS_DIR_IMAGES .'countries/'. strtolower(customer::$data['country_code']) .'.png'; ?>" alt="<?php echo functions::reference_get_country_name(customer::$data['country_code']); ?>" title="<?php echo functions::reference_get_country_name(customer::$data['country_code']); ?>" style="vertical-align: baseline;" /></li>
    <li class="change"><a href="<?php echo document::href_ilink('regional_settings'); ?>" data-toggle="lightbox"><?php echo language::translate('title_change', 'Change'); ?></a></li>
  </ul>
</div>
