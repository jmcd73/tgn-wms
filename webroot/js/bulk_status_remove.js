$(function () {
  //  $('input[type="radio"]').change(function(e){
  //      console.log($(this).is(':checked'));
  //  })

  $("#PalletChangeTo").change(function (e) {
    console.log("select change" + $(this).val());
    form = $(this).closest("form");
    $val = $(this).val();
    inputs = form.find("input[value=" + $val + "]");
    $(inputs).prop("checked", true);
  });

  $('input[type="radio"]').click(function (e) {
    checked = $(this).data("checked");

    tr = $(this).closest("tr");

    if (parseInt(checked) === 0 || checked === undefined) {
      console.log("inChecked === 0 true if block");
      $(this).prop("checked", true);
      $(this).data("checked", 1);
      tr.addClass("success");
    } else {
      console.log("inChecked in false if block");
      $(this).prop("checked", false);
      tr.removeClass("success");
      tr.find('input[type="radio"]').each(function () {
        $(this).data("checked", 0);
      });
    }
  });
});
