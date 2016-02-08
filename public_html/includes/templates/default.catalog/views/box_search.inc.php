<?php echo functions::form_draw_form_begin('search_form', 'get', document::ilink('search')); ?>
  <div class="input-group">
    <?php echo functions::form_draw_search_field('query', true, 'placeholder="'. language::translate('text_search_products', 'Search products') .'…"'); ?>
    <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo functions::draw_fonticon('fa-search'); ?></button>
    </div>
  </div>
<?php echo functions::form_draw_form_end(); ?>