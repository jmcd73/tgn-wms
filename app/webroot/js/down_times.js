/*
 *  WMS
 *  Toggen <james@toggen.com.au> 0428 964 633
 */

$(function() {
  $("#DownTimeReportDateId").change(function() {
    // alert(this.value);
    var options = $("#DownTimeReportId");
    options.find("option").remove();
    options.append($("<option />"));
    $.getJSON("../down_times/productList/" + this.value, function(result) {
      $.each(result.data, function() {
        //alert(this);
        options.append(
          $("<option />")
            .val(this.id)
            .text(this.part)
        );
      });
    });
  });
});
