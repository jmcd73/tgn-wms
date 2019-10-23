$(function () {
    console.log("ready reason_codes");

    $('[name="data[ReasonCode][downtime_type_id]"]').change(function () {
        console.log("changed " + $(this).val());
        url = $(this).data('url');
        url = url + '/' + $(this).val();
        data = '';
        $.ajax({
            type: "POST",
            url: url,
            data: {},
            success: function (data, status, jqXHR) {
                console.log(data);
                select = $('select[name="data[ReasonCode][parent_id]"]');
                select.empty();
                $.each(data.prca, function (index) {
                    select.append($("<option />").val(this.value).html(this.text));
                    console.log(this);
                });
            },
            dataType: 'JSON'
        });
    });

});


