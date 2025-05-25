$(document).ready(function () {
  $(".dashboard-container").hide();

  $("#product-input").on("change", function () {
    const [file] = $(this).prop("files");

    if (file) {
      $("#product-preview").attr("src", URL.createObjectURL(file));
    }
  });

  //get url params
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  displayProduct(id);

  $("#edit-button").click(() => {
    if (!$(".edit")[0].checkValidity()) {
      $(".edit")[0].reportValidity();
      return;
    }

    editProduct(id);
  });
});

let product;

function displayProduct(id) {
  let displayReq = new XMLHttpRequest();

  displayReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      product = JSON.parse(this.responseText);

      $("#name").val(product.name);
      $("#type").val(product.type);
      $("#price").val(product.price);
      $("#quantity").val(product.quantity);
      $("#description").val(product.description);

      let productPreview = $("#product-preview");

      productPreview.attr("src", product.location);
    }
  };

  displayReq.open("POST", "api/products/fetch_id.php", true);
  displayReq.send(JSON.stringify({ id: id }));
}

function editProduct(id) {
  const [file] = $("#product-input").prop("files");

  let editData = JSON.stringify({
    id: id,
    name: $("#name").val().toUpperCase(),
    type: $("#type").val(),
    price: $("#price").val(),
    quantity: $("#quantity").val(),
    description: $("#description").val(),
    location: file ? "assets/" + file.name : product.location,
  });

  let updateReq = new XMLHttpRequest();

  updateReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let updateRes = JSON.parse(this.responseText);

      if (updateRes.success == true) {
        toastr.success(updateRes.message, "Success", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
          onHidden: () => {
            uploadPicture();
            window.location.href = "dashboard.php?page=view-products";
          },
        });
      } else {
        toastr.warning(updateRes.message, "Warning", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
        });
      }
    }
  };

  updateReq.open("POST", "api/products/update.php", true);
  updateReq.send(editData);
}

function uploadPicture() {
  let picture = $("#product-input").prop("files")[0];
  let pictureData = new FormData();
  pictureData.append("picture", picture);
  let uploadReq = new XMLHttpRequest();
  uploadReq.open("POST", "utils/upload_image.php", true);
  uploadReq.send(pictureData);
}
