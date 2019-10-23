$(document).ready(function () {

//    $('#ReportMachineId').change(function(){
//            alert("change");
//        } );

    machine_id = $('#ReportMachineId');
    url = window.location.pathname;
    url = url.toLowerCase();

// only if in add mode do the onload update
    if (!(url.indexOf('edit') !== -1)) {
        get_value($(machine_id));
    }

    $('#update_shift_minutes').click(
            function (event) {
                event.preventDefault();
                get_value();

            });
    machine_id.change(function () {
        get_value()
    });



});

function get_value() {


    report_id = $('#ReportId').val();


    report_date_id = $('#ReportReportDateId').val();
    report_shift_minutes = $('#ReportShiftMinutes');
    report_item_id = $('#ReportItemId').val();
    report_machine_id = $('#ReportMachineId').val();
    // jQuery.post( url [, data ] [, success ] [, dataType ] )
    data_url = $('#data-url').attr('data-url') + '.json';

    post_object = {
        'report_date_id': report_date_id,
        'report_machine_id': report_machine_id,
        'item_id': report_item_id,
        'shift_minutes': report_shift_minutes.val()

    };

    if (report_id) {
        post_object.report_id = report_id
    }

    $.ajax({
        type: "POST",
        url: data_url,
        data: post_object,
        success: function (data) {
            report_shift_minutes.val(data.ret.shift_minutes);
        },
        dataType: 'JSON'
    });

    console.log(
            "data-url " + data_url + "\n" +
            "ReportDateId " + report_date_id + "\n" +
            "ReportShiftMinutes " + report_shift_minutes + "\n" +
            "ReportItemId " + report_item_id);


}