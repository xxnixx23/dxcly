$(document).ready(function () {
  $(".dashboard-container").hide();

  fetchOrders();
});

let products = [];

function fetchOrders() {
  let productsReq = new XMLHttpRequest();

  productsReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      products = JSON.parse(this.responseText);

      displayProducts();
    }
  };

  productsReq.open("GET", "api/products/fetch.php", true);
  productsReq.send();
}

function displayProducts() {
  $("#products-body").empty();

  let searchVal = $("#search").val().toLowerCase();

  let filterTerm = $("#filter").val();

  let results = 0;

  products.forEach((product) => {
    if (product.name.toLowerCase().includes(searchVal) || !searchVal) {
      if (filterTerm == product.type.toLowerCase() || !filterTerm) {
        let productTableRow = $("<tr></tr>");
        let checkbox = $("<td></td>").append(
          $("<input>").attr("type", "checkbox").addClass("product-checkbox")
        );
        productTableRow.append(checkbox);
        productTableRow.append($("<td></td>").text(product.id));
        productTableRow.append($("<td></td>").text(product.name));
        productTableRow.append(
          $("<td></td>").append($("<img>").attr("src", product.location))
        );
        productTableRow.append($("<td></td>").text(product.price));
        productTableRow.append($("<td></td>").text(product.type));
        productTableRow.append($("<td></td>").text(product.description));
        productTableRow.append($("<td></td>").text(product.quantity));

        let editBtn = $("<span>")
          .text("edit")
          .addClass("material-symbols-outlined")
          .attr("id", "edit-btn")
          .click(function () {
            window.location.href =
              "dashboard.php?page=edit-product&id=" + product.id;
          });

        let deleteBtn = $("<span>")
          .text("delete")
          .addClass("material-symbols-outlined")
          .attr("id", "delete-btn")
          .click(function () {
            deleteProduct(product.id);
          });

        let actions = $("<div>").addClass("actions");

        actions.append([editBtn, deleteBtn]);

        productTableRow.append($("<td></td>").append(actions));

        if (product.quantity == 0) {
          productTableRow.css("opacity", "0.5");
        }

        $("#products-body").append(productTableRow);
        results++;
      }
    }
  });

  $("#products-body tr").slice(3).hide();
  $("#pagination").pagination({
    items: results,
    itemsOnPage: 3,
    cssStyle: "dark-theme",
    onPageClick: function (pageNumber) {
      $("#products-body tr").hide();
      $("#products-body tr")
        .slice((pageNumber - 1) * 3, pageNumber * 3)
        .show();
    },
  });

  $("#select-all").change(function () {
    if ($(this).is(":checked")) {
      $(".product-checkbox").prop("checked", true);
      $("#delete-button").css("display", "block");
    } else {
      $(".product-checkbox").prop("checked", false);
      $("#delete-button").css("display", "none");
    }
  });

  $(".product-checkbox").click(function () {
    if ($(this).is(":checked")) {
      $("#delete-button").css("display", "block");
    } else {
      $("#delete-button").css("display", "none");
    }
  });
}

function deleteProducts() {
  let selectedProductCheckboxes = $(".product-checkbox:checked");
  selectedProductCheckboxes.each(function () {
    let productTableRow = $(this).closest("tr");
    let idColumn = productTableRow.find("td:nth-child(2)").text();

    deleteProduct(idColumn);
  });

  $("#delete-button").css("display", "none");
  $("#select-all").prop("checked", false);
}

function deleteProduct(id) {
  let deleteReq = new XMLHttpRequest();

  deleteReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let deleteRes = JSON.parse(this.responseText);

      if (deleteRes.success == true) {
        toastr.success(deleteRes.message, "Success", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
          // Redirect
          onHidden: function () {
            fetchOrders();
          },
        });
      } else {
        toastr.error(deleteRes.message, "Failed", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
        });
      }
    }
  };

  deleteReq.open("DELETE", "api/products/delete.php", true);
  deleteReq.send(JSON.stringify({ id: id }));
}
