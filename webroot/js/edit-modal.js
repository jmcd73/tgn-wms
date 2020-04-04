var settings = {};
settings.printModal = "#cartonLabelPrintModal";
settings.productList = "#product-list";
settings.itemControlId = "#cartons-item";
settings.modalPrintButton = "#modal-print-button";
settings.numLabelRadios = 'input[name="printer_id"]:checked';
$(function() {
  //create closure so we can safely use $ as alias for jQuery
  $("#edit-modal").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var modal = $(this);
    modal.find(".modal-title").text("Edit Options");
    modal.find("h3.tgn-title").html(button.data("codedesc"));
    var editPalletCartonsLink = modal.find("a#editPalletCartons");
    var moveOrEditLink = modal.find("a#moveOrEdit");
    editPalletCartonsLink.attr("href", button.data("editpalletcartons"));
    moveOrEditLink.attr("href", button.data("moveoredit"));
  });
});
