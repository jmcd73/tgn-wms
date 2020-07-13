/*
 *  WMS
 *  Toggen <james@toggen.com.au> 0428 964 633
 */

$(function () {
  var pl_ref = $("#pl_ref");

  submit_url = pl_ref.data("submit_url");

  var palletReferences = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY",
    },
  });

  $("#pl_ref").typeahead(null, {
    name: "pallet-references",
    display: "value",
    templates: {
      empty: ['<div class="empty-message">', "No results", "</div>"].join("\n"),
      suggestion: function (item) {
        return (
          "<div><strong>" + item.value + "</strong> - " + item.label + "</div>"
        );
      },
    },
    limit: 500,
    source: palletReferences,
  });

  var item = $("#item_id_select");

  submit_url = item.data("submit_url");

  var itemCodes = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY",
    },
  });

  $("#item_id_select").typeahead(null, {
    name: "item-code",
    display: "value",
    templates: {
      empty: ['<div class="empty-message">', "No results", "</div>"].join("\n"),
      suggestion: function (item) {
        return (
          "<div><strong>" + item.value + "</strong> - " + item.label + "</div>"
        );
      },
    },
    limit: 500,
    source: itemCodes,
  });

  batch = $("#batch");

  submit_url = batch.data("submit_url");

  var batchCodes = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY",
    },
  });

  $("#batch").typeahead(null, {
    name: "batch-code",
    display: "value",
    templates: {
      empty: ['<div class="empty-message">', "No results", "</div>"].join("\n"),
      suggestion: function (item) {
        return (
          "<div><strong>" + item.value + "</strong> - " + item.label + "</div>"
        );
      },
    },
    limit: 500,
    source: batchCodes,
  });
});

function clearForm(form) {
  elements = form.elements;

  for (i = 0; i < elements.length; i++) {
    switch (elements[i].name) {
      case "inventory_status_id":
      case "bb_date":
      case "production_date":
      case "location_id":
      case "shipment_id":
        elements[i].value = '';
        break;
      default:
        // do nothing
        break;
    }

  }

  // clear typeaheads

  setTimeout(function () {
    $('.typeahead').typeahead('val', '');
  }, 100);
}