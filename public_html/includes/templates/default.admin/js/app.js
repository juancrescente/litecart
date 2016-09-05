$(document).ready(function(){

// Set Head Title
  if ($('h1')) {
    if (document.title.substring(0, $('h1:first').text().length) == $('h1:first').text()) return;
    document.title = $('h1:first').text() +' | '+ document.title;
  }

// Enable tooltips
  $('[data-toggle="tooltip"]').tooltip();

// Form required asterix
  $(':input[required="required"]').closest('.form-group').addClass('required');

// AJAX Search
  var timer_ajax_search = null;
  $('#search input[name="query"]').on('propertychange input', function(){

    if ($(this).val() != '') {
      $('#box-apps-menu').fadeOut('fast');
      $('#search .results').html('<div class="loading text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></div>');
      var query = $(this).val();

      clearTimeout(timer_ajax_search);
      timer_ajax_search = setTimeout(function() {
        $.ajax({
          type: 'get',
          async: true,
          cache: false,
          url: 'search_results.json.php?query=' + query,
          dataType: 'json',
          beforeSend: function(jqXHR) {
            jqXHR.overrideMimeType('text/html;charset=' + $('html meta[charset]').attr('charset'));
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#search results').text(textStatus + ': ' + errorThrown);
          },
          success: function(json) {
            $('#search .results').html('');
            $.each(json, function(i, group){
              if (group.results.length) {
                $('#search .results').append(
                  '<h4>'+ group.name +'</h4>' +
                  '<ul class="list-group" data-group="'+ group.name +'"></ul>'
                );
                $.each(group.results, function(i, result){
                  $('#search .results ul[data-group="'+ group.name +'"]').append(
                    '<li class="list-group-item">' +
                    '  <div class="title"><a href="'+ result.url +'">'+ result.title +'</a></div>' +
                    '  <div class="description"><small>'+ result.description +'</small></div>' +
                    '</li>'
                  );
                });
              }
            });
            if ($('#search .results').html() == '') {
              $('#search .results').html('<p class="text-center no-results"><em>:(</em></p>')
            }
          }
        });
      }, 500);

    } else {
      $('.sidebar .results').html('');
      $('#box-apps-menu').fadeIn('fast');
    }
  });

// Data-Table Toggle Checkboxes
  $('.data-table *[data-toggle="checkbox-toggle"]').click(function() {
    $(this).closest('.data-table').find('tbody :checkbox').each(function() {
      $(this).prop('checked', !$(this).prop('checked'));
    });
    return false;
  });

  $('.data-table tbody tr').click(function(event) {
    if ($(event.target).is('input:checkbox')) return;
    if ($(event.target).is('a, a *')) return;
    if ($(event.target).is('th')) return;
    $(this).find('input:checkbox').trigger('click');
  });

});