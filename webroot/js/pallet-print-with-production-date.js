$(function () {
  // when inputs change re-write the cookies

  $(":input:not(:checkbox)").change(function () {
    form = $(this).closest("form");
    setCookieValuesFromForm(form);
  });

  // reads product type from form, stores data as cookies
  $("form.pallet-print").each(function () {
    setFormValuesFromCookies(this);
  });

  // when submitting set a cookie to the value of the forms
  // so on reload the values can be set to the saved values
  $("form.pallet-print").on("submit", function (e) {
    form = $(this);
    form.each(function () {
      setCookieValuesFromForm(form);
    });
    $("#dialog").modal("hide");

    console.log(new Date().toLocaleString() + " submit called");
  });

  // this is the ok/print dialog
  $("#dialog")
    .off("show.bs.modal")
    .on("show.bs.modal", function (event) {
      var button = $(event.relatedTarget);

      var formName = button.data("formname");

      var form = $("#" + formName);

      var item_val = form
        .find("select.form-control.item option:selected")
        .text();

      var modal = $(this);

      // put the product name in the dialog text
      modal.find(".modal-body strong").html(item_val);

      // de-register click and add it back to
      // stop multiple form submits
      $("button.modal-print")
        .off("click")
        .on("click", function () {
          $("#" + formName).submit();
        });
    });

  // when item number select changes
  // disable the qty control if it is there and hide it
  // uncheck the part pallet checkbox too
  $("select.form-control.item").change(function () {
    qty = $(this).closest("form").find("select.form-control.qty");

    qty.attr("disabled", true);

    qty_div = qty.parent("div");

    qty_div.hide(400);

    part_pallet = $(this).closest("form").find('input[type="checkbox"]');

    part_pallet.prop("checked", false);
  });


  $('input.production-date[type="checkbox"]').change(function () {
    checked = $(this).prop("checked");
    input = $(this).closest('div.input-group').find('input.production-date[type="date"]');

    if (checked) {
      input.attr('disabled', false);
    } else {
      input.attr('disabled', true)
    }
  });


  // part pallet checkbox
  $('input.part-pallet[type="checkbox"]').change(function () {
    checked = $(this).prop("checked");

    itemselect = $(this).closest("form").find("select.form-control.item");

    item_id = itemselect.val();

    qty = $(this).closest("form").find("select.form-control.qty");

    if (checked) {
      qty.attr("disabled", false);
    }

    qty_div = qty.parent("div");

    queryurl = $(this).data("queryurl");

    console.log("item : " + item_id + " url: " + queryurl, checked);
    if (item_id && checked) {
      qty_div.show(600);

      $.get(
        queryurl + "/" + item_id,
        function (data) {
          var options = "";
          pallet_qty = data.quantity;
          window.console && console.log("pallet_qty :" + pallet_qty);
          for (i = 1; i < pallet_qty; i++) {
            options += '<option value="' + i + '">' + i + "</option>";
          }
          qty.html(options);
        },
        "json"
      );
    } else {
      $(this).prop("checked", false);

      qty_div.hide(600);
      qty.attr("disabled", true);
    }

    $(this).button("refresh");
  });
});

function setFormValuesFromCookies(form) {
  var productTypeInput = $(form).find("input.productType");
  productTypeId = productTypeInput.val();
  var formNameVal = $(form).attr("id");
  //console.log('setFormValuesFromCookies', formNameVal);
  // set controls to cookie values
  $(form)
    .find(":input:visible")
    .each(function () {
      control_name = $(this).prop("name");
      control_name_pt =
        productTypeId + "-" + formNameVal + "-" + control_name;

      switch (control_name) {
        case formNameVal + '-' + 'item':
        case formNameVal + '-' + 'production_line':
          $(this).val($.cookie(control_name_pt));
          break;
        default:
          break;
      }
    });
}

function setCookieValuesFromForm(form) {
  var part_pallet = $(form).find('input[type="checkbox"]');
  part_pallet.prop("checked", false);
  var productType = $(form).find('input[type="hidden"].productType');
  var formNameVal = $(form).attr("id");

  pt = productType.val();

  $(form)
    .find(":input:visible")
    .each(function () {
      control_name = $(this).prop("name");

      if (control_name) {
        // store only the form controls we want
        // window.console && console.log('submit ' + $(this).prop('name') + ' : ' + $(this).val());
        $.cookie(pt + "-" + formNameVal + "-" + control_name, $(this).val(), {
          expires: 999,
        });
      }
    });
}
