/*
 *  WMS
 *  Toggen <james@toggen.com.au> 0428 964 633
 */


$(function () {


    $('#booked_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true

    });


    destination_control = $('#address');

    submit_url = destination_control.data('submit_url');
    destination_control.click(function(){
      console.log("click dc", submit_url);
    })
     var destinations = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + '?term=%QUERY',
      wildcard: '%QUERY'
    }
  });


$('#address').typeahead(null, {
      name: 'address',
      display: 'value',
      templates: {
          suggestion: function (pl) {

              return '<p>' + pl.value + '</p>';
          }
      },
      limit: 500,
      source: destinations
  });


});
