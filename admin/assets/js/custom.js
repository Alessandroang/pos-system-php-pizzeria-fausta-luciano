$(document).ready(function () {
  alertify.set("notifier", "position", "top-right");

  $(document).on("click", ".increment", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();
    var currentValue = parseInt($quantityInput.val());

    if (!isNaN(currentValue)) {
      var qtyVal = currentValue + 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  $(document).on("click", ".decrement", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();
    var currentValue = parseInt($quantityInput.val());

    if (!isNaN(currentValue) && currentValue > 1) {
      var qtyVal = currentValue - 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  function quantityIncDec(prodId, qty) {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        productIncDec: true,
        product_id: prodId,
        quantity: qty,
      },

      success: function (response) {
        var res = JSON.parse(response);

        if (res.status == 200) {
          $("#productArea").load(" #productContent ");
          alertify.success(res.message);
        } else {
          $("#productArea").load(" #productContent ");
          alertify.error(res.message);
        }
      },
    });
  }

  // Proceed to place order button click
  $(document).on("click", ".proceedToPlace", function () {
    var cphone = $("#cphone").val();
    var payment_mode = $("#payment_mode").val();

    if (payment_mode === "") {
      swal("Select Payment Mode", "Select Your Payment Mode", "warning");
      return false;
    }

    if (cphone === "" || !$.isNumeric(cphone)) {
      swal("Enter Phone Number", "Enter a valid phone number", "warning");
      return false;
    }

    var data = {
      proceedToPlaceBtn: true,
      cphone: cphone,
      payment_mode: payment_mode,
    };

    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status === 200) {
          window.location.href = "order-summary.php";
        } else if (response.status === 404) {
          swal({
            text: response.message,
            icon: "error",
            buttons: {
              catch: {
                text: "Add Customer",
                value: "Catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "Catch":
                $("#addCustomerModal").modal("show");
                // console.log("Pop the customer add modal");
                break;
              default:
            }
          });
        } else {
          swal(response.message, response.message, "error");
        }
      },
      error: function () {
        swal(
          "Error",
          "An error occurred while processing your request",
          "error"
        );
      },
    });
  });
});
