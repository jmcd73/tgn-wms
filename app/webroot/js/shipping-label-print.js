var address_object = {};

var dests_obj = ["PICK ONE...",
	"NSW", "NT", "VIC", "QLD", "SA", "WA", "TAS", "ACT", // australia
	"AUCKLAND", "WELLINGTON", "LYTTELTON", // new zealand
	"SINGAPORE",
	"MALAYSIA",
	"MAURITIUS",
	"LONG BEACH USA",
	"CUSTOM..."];

//this is the field that displays when custom... is selected in the destination select
var state_html = '<input class="form-control" id="dests" type="text" name="state" maxlength="14" size="14">'

// document.ready
$(function () {

	$('input[name="address"]').on('input', function () {
		console.log("in change address");
		$(this).css(
			'background-color', 'white'
		);
	});
	$('.radio-span').click(function () {
		$(this).children('input[type="radio"]').prop('checked', true);
		log("radio-span");
	});

	$('form').submit(function () {
		var radio_val = $('input[name="printer"]:checked').val();

		if (!radio_val) {
			// cancel submit on no printer selection
			$('#error').html('<div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span> Please select a printer.</div>');
			return false;
		} else {
			$('#error').hide();
		};
	});

	// reset button test
	$('#reset-button').click(function () {
		$('#dests-container').empty();
		$('#dests-container').html('<select class="form-control" id="dests" name="state"><select>');
		populate_destinations(dests_obj);
		//.on( events [, selector ] [, data ], handler(eventObject) )
		$('#dests').on('change', function () {

			if ($('#dests').val() == "CUSTOM...") {

				$('#dests-container').empty();
				$('#dests-container').html(state_html);
			}

		});

		$('input').css('background-color', 'white');
	});


	$('#dests').change(function () {

		if ($(this).val() == "CUSTOM...") {
			$('#dests-container').empty();
			$('#dests-container').html(state_html);
		}

		$(this).css('background-color', "white");
	});

	$('input[type="submit"], input[type="reset"]').button();

	$('input[type="submit"]').click(function (event) {

		seq_start = $('select[name="sequence-start"]');
		pall_no = $('select[name="total-pallets"]');
		ok_to_go = true;

		dests = $('#dests');

		if (dests.val() == "PICK ONE...") {
			ok_to_go = false;
			dests.css('background-color', "yellow");
		} else {
			dests.css('background-color', "white");
		}

		if (seq_start.val() > pall_no.val()) {

			ok_to_go = false;
			seq_start.prop('selectedIndex', 0);
		};



		var exit_each = false;
		$('input[type="text"]').each(function () {
			if ($(this).val() == "") {

				$(this).css('background-color', "yellow");
				$(this).focus();
				if (ok_to_go) { ok_to_go = false }
				exit_each = true;
			} else {
				$(this).css('background-color', "white");
			}

			if (exit_each) return false;
		});



		if (!ok_to_go) {
			event.preventDefault();
			return false;
		}


	});

	populate_destinations(dests_obj);

}); // end doc ready

function populate_destinations(dest) {
	var select_dest = $('#dests');
	var dest_options = '';
	for (i = 0; i < dest.length; i++) {
		dest_options += '<option>' + dest[i] + '</option>';
	}
	select_dest.html(dest_options);
};


function log(x) {

	window.console && console.log(x);

};

function load_address_select(obj) {

	var address_select = $("#ship-to");

	var option_string = '';

	for (key in obj) {

		option_string += '<option value="' + obj[key] + '">' + obj[key].code + ' : ' + obj[key].name + ' : ' + obj[key].city + ' : ' + obj[key].state + '</option>';

	}

	address_select.html(option_string);
}

