$(function () {

//  $('input[type="radio"]').change(function(e){
//      console.log($(this).is(':checked'));
//  })

$('#LabelChangeTo').change(function(e){
    console.log('select change' + $(this).val());
    form = $(this).closest('form');
    inputs = form.find('input[value='+ $(this).val() + ']');
    console.log(inputs.length);
    $(inputs).prop('checked', true);
})

    $('input[type="radio"]').click(function (e) {
        checked = $(this).data('checked');
        tr = $(this).closest('tr');
        if (parseInt(checked) === 0) {
            $(this).prop('checked', true);
            $(this).data('checked', 1)
            tr.addClass('success');
        } else {

            $(this).prop('checked', false)
            tr.removeClass('success');
            tr.find('input[type="radio"]').each(function () {
                $(this).data('checked', 0)
            });

        }

    })

})
