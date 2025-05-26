$(document).ready(function () {
  $(".dashboard-container").hide();

  $("#product-input").on("change", function () {
    const [file] = $(this).prop("files");

    if (file) {
      $("#product-preview").attr("src", URL.createObjectURL(file));
    }
  });

  $("#create-button").click(() => {
    if (!$(".create")[0].checkValidity()) {
      $(".create")[0].reportValidity();
      return;
    }

    createProduct();
  });
});

function createProduct() {
  const [file] = $("#product-input").prop("files");

  let createData = JSON.stringify({
    name: $("#name").val().toUpperCase(),
    type: $("#type").val(),
    price: $("#price").val(),
    quantity: $("#quantity").val(),
    description: $("#description").val(),
    location: file ? "assets/" + file.name : "assets/default-product.png",
  });

  let createReq = new XMLHttpRequest();

  createReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let createRes = JSON.parse(this.responseText);

      if (createRes.success == true) {
        toastr.success(createRes.message, "Success", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
          onHidden: () => {
            uploadPicture();
            window.location.href = "dashboard.php?page=create-product";
          },
        });
      } else {
        toastr.warning(createRes.message, "Warning", {
          timeOut: 2000,
          preventDuplicates: true,
          positionClass: "toast-bottom-left",
        });
      }
    }
  };

  createReq.open("CREATE", "api/products/create.php", true);
  createReq.send(createData);
}

function uploadPicture() {
  let picture = $("#product-input").prop("files")[0];
  let pictureData = new FormData();
  pictureData.append("picture", picture);
  let uploadReq = new XMLHttpRequest();
  uploadReq.open("POST", "utils/upload_image.php", true);
  uploadReq.send(pictureData);
}
