/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

    //onload too
    count = $('input[name="data[Shipment][Label][]"]:checked').length;
    $('#selected_label_count').html(count);

    $('input[name="data[Shipment][Label][]"]').click(function(){
        count = $('input[name="data[Shipment][Label][]"]:checked').length;

        $('#selected_label_count').html(count);
        console.log("clickity" + count);
    });


    var cb_div = $('input[type=checkbox]:disabled').parent();

    cb_div.addClass('bg-danger');

    cb_div.each(function () {
        $(this).attr('data-toggle', 'popover');
        $(this).attr('data-trigger', 'focus');
        $(this).attr('tabindex', 0);
        $(this).attr('data-placement', 'top');
        $(this).attr('title', 'Low Dated Stock');

    });
    $('[data-toggle="popover"]').popover({
        content: tooltip(),
        html: true
    })

    destination_control = $('#ShipmentDestination');

    submit_url = destination_control.data('submit_url');

     var destinations = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: '../data/films/post_1960.json',
  remote: {
    url: submit_url + '?term=%QUERY',
    wildcard: '%QUERY'
  }
});


destination_control.typeahead(null, {
  name: 'value',
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

function tooltip() {

    return '<p>This pallet doesn&apos;t have enough life left before it expires to allow it to ship</p>' +
            '<p>You won&apos;t be able to add this pallet to a shipper until you mark it as being allowed to ship.</p>' +
            '<p><ol><li>Leave this screen and go to Warehouse => View Stock.</li>' +
            '<li>Find the pallet and click it&apos;s "Edit" link</li>' +
            '<li>If a login screen appears login with your username and password</li>' +
            '<li>Tick the &quot;Ship low dated&quot; checkbox</li>' +
            '<li>click Submit</li></ul><p>';
}

