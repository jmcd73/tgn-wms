var settings = {};
settings.printModal = "#cartonLabelPrintModal";
settings.productList = "#product-list";
settings.itemControlId = "#cartons-item";
settings.modalPrintButton = "#modal-print-button";
settings.numLabelRadios = 'input[name="printer_id"]:checked';
$(function() {
	//create closure so we can safely use $ as alias for jQuery

	$(settings.printModal).on("show.bs.modal", function(event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var modal = $(this);
		modal.find(".modal-title").text("Carton Label Print");

		label_details = getLabelDetails();

		s = label_details.count > 1 ? "s" : "";

		question =
			"Do you wish to print <strong>" +
			label_details.count +
			"</strong> label" +
			s +
			" of type <strong>" +
			label_details.description +
			"</strong> to the <strong>" +
			label_details.printer_friendly_name +
			"</strong> printer?";

		modal.find("#label-count").html(question);
	});

	$(settings.modalPrintButton).click(function() {
		$(settings.printModal).modal("hide");
		sendPrint();
	});

	product_list_url = $(settings.productList).data("url");
	settings.print_url = $(settings.productList).data("print_url");
	//console.log(jmits.print_url);
	$("#cartons-label-count .qty").click(function() {
		$(this)
			.addClass("active")
			.siblings()
			.removeClass("active");
	});

	var item_input = $(settings.itemControlId);

	$("button.keypad").click(function(e) {
		button = $(this);
		val = button.data("value");
		updateItemCode(val);
	});

	var itemCodes = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		//prefetch: '../data/films/post_1960.json',
		remote: {
			url: product_list_url + "/?term=%QUERY",
			wildcard: "%QUERY"
		}
	});

	item_input.typeahead(null, {
		name: "item-code",
		display: function(item) {
			return item.Item.code;
		},

		templates: {
			suggestion: function(pl) {
				return "<p>" + pl.Item.name + "</p>";
			}
		},
		limit: 500,
		source: itemCodes
	});

	item_input.bind("typeahead:select", function(ev, suggestion) {
		$("#cartons-desc").val(suggestion.Item.description);
		$("#cartons-gtin14").val(suggestion.Item.trade_unit);
	});
});

function getPrintQty() {
	print_qty = $("button.qty");

	total = 0;
	print_qty.each(function() {
		if ($(this).hasClass("active")) {
			// console.log($(this).attr('id'));
			total = $.trim($(this).text());
		}
	});

	return parseInt(total);
}

function callPrint() {
	if (validateInput()) {
		$(settings.printModal).modal("show");
	}
}

function sendError(text, level ) {
	if ( level === undefined ) {
		level = 'success';
	}
	alert_text =
		'<div class="alert alert-' +
		level +
		' alert-dismissible" role="alert">' +
		'<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>' +
		'<span class="sr-only">Error: </span>' +
		"&nbsp;" +
		text +
		'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
		'<span aria-hidden="true">&times;</span>' +
		"</button>" +
		"</div>";

	$("#global-error").html(alert_text);
}

function getPrinter() {
	var radio = $(settings.numLabelRadios);
	var radio_val = radio.val();

	return radio_val;
}

function getPrinterFriendlyName() {
	var radio = $(settings.numLabelRadios);
	label = radio.closest("label");
	return $.trim(label.text());
}

function getLabelDetails() {
	return {
		barcode: $("#cartons-gtin14").val(),
		print_action: $("#print_action").val(),
		description: $("#cartons-desc").val(),
		count: getPrintQty(),
		printer_id: getPrinter(),
		printer_friendly_name: getPrinterFriendlyName()
	};
}
function sendPrint() {
	console.log("sendPrint");

	label_details = getLabelDetails();

	$.ajax({
		type: "POST",
		url: settings.print_url,
		data: label_details,
		dataType: "JSON",
		error: function(data) {

			sendError(
				"The data failed to send to the printer " +
					"with a status <strong>" +
					data.status +
					": " +
					data.statusText +
					"</strong> error message",
				"danger"
			);
		},
		success: function(data) {
			var data = data.data;
			var message = "";
			var errType = data.return_value === 0 ? "success" : "danger";
			if (data.return_value === 0) {
				message = "Success";
			} else {
				message = data.stderr;
				errType = 'danger';
			}
			sendError(
				"The data was sent to <strong>" +
					data.printer_friendly_name +
					"</strong> - <strong>Result: </strong> " +
					message,
				errType
			);
		}
	});
}
function validateInput(val) {
	gtin = $("#cartons-gtin14").val();
	desc = $("#cartons-desc").val();

	if (gtin !== "" && desc !== "") {
		return true;
	}
	sendError("Missing required information", "danger");

	return false;
}

function getItemCurrentVal(id) {
	item_input = $(id);
	current_val = item_input.val();
	return current_val;
}
function updateItemCode(key) {
	item_id = settings.itemControlId;
	current_val = getItemCurrentVal(item_id);

	var next_val = "";

	if (key === "print") {
		callPrint();
		return;
	}
	if (key === "back-space") {
		next_val = current_val.substring(0, current_val.length - 1);
	}
	if (key === "delete") {
		clearInputs();
		return;
	}

	// if it's a number append the value
	if (/^\d+$/.test(key)) {
		next_val = current_val + key;
	}

	setValShowTypeAhead(item_id, next_val);
}

function clearInputs() {
	$("input[type=text]").val("");
}

function setValShowTypeAhead(id, val) {
	$(id).typeahead("val", "");
	$(id)
		.focus()
		.typeahead("val", val)
		.focus();
}
