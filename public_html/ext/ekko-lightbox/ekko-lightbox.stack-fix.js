/*
$(document).on('shown.bs.modal', function (e) {
    $(e.target).before($(e.target).find('.modal-backdrop').clone().css('z-index', $(e.target).css('z-index')-1)); 
    $(e.target).find('.modal-backdrop').removeClass('in').css('transition', 'none');
});

$(document).on('hide.bs.modal', function (e) {
    $(e.target).prev('.modal-backdrop').remove();
});
*/

// Scroll fix
$('*[data-toggle=lightbox]').on('click', function(){
  var currentDialog = $(this).closest('.modal-dialog'), targetDialog = $($(this).attr('data-target'));
  if (!currentDialog.length) return;
  alert('x');
  targetDialog.data('previous-dialog', currentDialog);
  currentDialog.addClass('aside');
  var stackedDialogCount = $('.modal.in .modal-dialog.aside').length;
  if (stackedDialogCount <= 5){
    currentDialog.addClass('aside-' + stackedDialogCount);
  }
});

$('.modal').on('hide.bs.modal', function(){
  var $dialog = $(this);  
  var previousDialog = $dialog.data('previous-dialog');
  if (previousDialog){
    previousDialog.removeClass('aside');
    $dialog.data('previous-dialog', undefined);
  }
});