/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('input.entered').on('input', function () {
        console.log($(this).val());
        var conv_val = $(this).closest('tr').find('input.converted').attr('data-conv_factor');
        if (!conv_val) {
            var conv_val = $('#conv_factor').val();
        }
        value = $(this).val() * conv_val;
        console.log(value);
        var field = $(this).closest('tr').find('input.converted');
        console.log(field);
        if (field.length == 0) {
            field = $("#converted");
        }

        field.val(Math.round(value));
    })
});