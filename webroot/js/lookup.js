/*
 *  WMS
 *  Toggen <james@toggen.com.au> 0428 964 633
 */

$(function() {
  $("#resetButton").click(function() {
    document.getElementById("searchForm").reset();
    $("input:text, select").val("");
  });

  //    $(document).on('input', 'input:text, select', function() {
  //
  //         var cntrl_name = $(this).attr('name');
  //         $('input:text:not([name="' + cntrl_name + '"]), select:not([name="' + cntrl_name + '"])').val('');
  //
  //    });

  $("#bb_date")
    .datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true
    })
    .attr("autocomplete", "off");

  $("#print_date")
    .datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true
    })
    .attr("autocomplete", "off");

  var pl_ref = $("#pl_ref");

  submit_url = pl_ref.data("submit_url");

  var palletReferences = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY"
    }
  });

  $("#pl_ref").typeahead(null, {
    name: "pallet-references",
    display: "value",
    templates: {
      suggestion: function(pl) {
        return "<p>" + pl.label + "</p>";
      }
    },
    limit: 500,
    source: palletReferences
  });

  var item = $("#item_id_select");

  submit_url = item.data("submit_url");

  var itemCodes = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY"
    }
  });

  $("#item_id_select").typeahead(null, {
    name: "item-code",
    display: "value",
    templates: {
      suggestion: function(pl) {
        return "<p>" + pl.label + "</p>";
      }
    },
    limit: 500,
    source: itemCodes
  });

  //
  //    item.autocomplete({
  //        source: submit_url,
  //        minLength: 2,
  //        select: function (event, ui) {
  //            //$("#item_id").val(ui.item.id);
  //            $(this).val(ui.item.value);
  //            console.log(ui);
  //            //$(this).closest('form').submit();
  //            return false;
  //        }
  //    });

  batch = $("#batch");

  submit_url = batch.data("submit_url");

  var batchCodes = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '../data/films/post_1960.json',
    remote: {
      url: submit_url + "?term=%QUERY",
      wildcard: "%QUERY"
    }
  });

  $("#batch").typeahead(null, {
    name: "batch-code",
    display: "value",
    templates: {
      suggestion: function(pl) {
        return "<p>" + pl.label + "</p>";
      }
    },
    limit: 500,
    source: batchCodes
  });
});
