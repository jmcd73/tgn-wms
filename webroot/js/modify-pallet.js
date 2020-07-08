/*
 *  WMS
 *  Toggen <james@toggen.com.au> 0428 964 633
 */

// parse a date in yyyy-mm-dd format
function parseDate(input) {
    var parts = input.match(/(\d+)/g);
    // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
    return new Date(parts[0], parts[1] - 1, parts[2]); // months are 0-based
  }
  
  function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + parseInt(days));
    dateWithDaysAdded = [
      result.getFullYear(),
      (result.getMonth() + 1).toString().padStart(2, 0),
      result.getDate().toString().padStart(2, 0),
    ].join("-");
    return dateWithDaysAdded;
  }
  
  function sumCartons() {
    var palletTotal = $("#total");
    var qtyNeeded = $("#qty-needed");
    var currentTotal = 0;
  
    $("input.carton-count").each(function (i, n) {
      currentTotal += parseInt($(n).val(), 10) || 0;
    });
  
    currentTotal = parseInt(palletTotal.val()) - currentTotal;

    console.log(
      "total:",
      palletTotal.val(),
      "needed:",
      qtyNeeded.val(),
      "ct",
      currentTotal
    );
    qtyNeeded.val(currentTotal);
  }
  
  $(function () {
    $daysLife = $("#ItemDaysLife").val();
  
    $(".date-input.production-date").change(function () {
      $dateInputVal = $(this).val();
  
      $addedDays = addDays($dateInputVal, $daysLife);
  
      console.log($dateInputVal, $daysLife, $addedDays);
  
      $bestBefore = $(this).closest("div.row").find("input.best-before");
      $bestBefore.val($addedDays);
  
      console.log($dateInputVal, $addedDays, 'Days Life', $daysLife);
    });
  
    $(".carton-count").change(function () {
      sumCartons();
    });
    $(".carton-count").keyup(function () {
      sumCartons();
    });
  
    /* $(".date-input")
      .datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
      })
      .attr("autocomplete", "off"); */
  });
  