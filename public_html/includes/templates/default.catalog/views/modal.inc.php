<div tabindex="-1" class="modal fade" id="<?php echo $id; ?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" data-dismiss="modal">×</button>
        <h3 class="modal-title"><?php echo !empty($heading) ? $heading : ''; ?></h3>
      </div>
      
      <div class="modal-body"></div>
      
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><?php echo language::translate('title_close', 'Close'); ?></button>
      </div>
    </div>
  </div>
</div>

<script>
$('<?php echo $selector; ?>').click(function(){
  $('.modal-body').empty();
  $('.modal-title').html($(this).parent('a').attr("title"));
  $($(this).parents('div').html()).appendTo('.modal-body');
  $('#<?php echo $id; ?>').modal({show:true});
});
</script>