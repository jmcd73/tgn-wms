$(function () {
    //$(document).tooltip();
    $("[title!=''][title]").attr('data-toogle', 'tooltip');
  $('[data-toggle="tooltip"]').tooltip();
    $('tr.downtime_data').hide();
    $('table.downtime_table').each(function () {
        var table = $(this);
        table.find('tr:first').click(function () {
            //$(this).parent().next().find('table').toggle();
            // alert("hi");
            table.find('tr.downtime_data').toggle();
        });
    });
});

 