/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('input.datepicker').datepicker({
        "format": 'dd/mm/yyyy',
        'autoclose': true,
         todayHighlight: true
    });
//    $('form').submit(function(){
//		var qty = $('select[name=qty]');
//                var printer = $('input[name=printer]');
//
//		var c = confirm(
//
//                "Quantity: " + qty.val() + "\n\nPrinter: " + printer.val() + "\n\n" +
//                "Please confirm you have loaded the 100x50 labels.\n\nClick OK to continue");
//		return c;
//	});

    $('#print1').click(function (event) {
        event.preventDefault();
    });

    $('#samplePrintModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var modal = $(this)
        var qty = $('select[name=qty]');
        var printer = $('input[name=printer]');
        var isplural = $('#isplural');
        $('#qty').text(qty.val());
        $('#printer').text(printer.val());

        if (parseInt(qty.val()) !== 1) {
            isplural.text('s');
        } else {
            isplural.empty();
        }


        var printer = $('input[name=printer]');

        $('#btn-print').off('click').on('click', function () {
            console.log("click");
            button.closest('form').submit();
        });
    });

});
