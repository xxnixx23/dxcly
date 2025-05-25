$(document).ready(function () {
  let lastScrollTop = 0;
  let header = $(".header");
  let top = $(".header .top");

  $(window).scroll(function (event) {
    let st = $(this).scrollTop();
    if (st > lastScrollTop) {
      // Scroll down
      header.css("height", "10vh"); // Set the minimized height
      header.css("justify-content", "center");

      top.hide();
    } else {
      // Scroll up
      if (st === 0) {
        header.css("height", "18vh"); // Set the original height when scrolled at the top
        header.css("justify-content", "space-between");

        top.show();
      } else {
        header.css("height", "10vh"); // Set the minimized height for other scroll positions
        header.css("justify-content", "center");
      }
    }
    lastScrollTop = st;
  });

  dropdownHandler();

  slidingTextHandler();

  userProfileHandler();

  cartHandler();

  mobileMenuHandler();
});

function mobileMenuHandler() {
  $("#menu-button").click(function () {
    $(".mobile-menu").css("display", "flex");
    $("body").css("overflow", "hidden");
    $("html, body").scrollTop(0);
  });

  $(".dropdown-mobile .items").hide();

  $(".dropdown-mobile .title").click(function () {
    $(this).find(".arrow").toggleClass("rotate-90");
    $(this).siblings(".items").slideToggle();
  });

  $("#close-menu").click(function () {
    $(".mobile-menu").css("display", "none");
    $("body").css("overflow", "scroll");
  });
}

function cartHandler() {
  //cart
  $("#cart-btn").click(function () {
    let userReq = new XMLHttpRequest();

    userReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let cartsReq = new XMLHttpRequest();

        let userData = JSON.parse(this.responseText);

        if (userData.loggedIn == "false") {
          toastr.warning("You need to login first.", "Warning", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
            // Redirect
            onHidden: function () {
              window.location.href = "login.php";
            },
          });
        } else {
          $(".cart-container").toggleClass("open");
          $(".cart-view").toggleClass("open");
          $("body").css("overflow", "hidden");

          cartsReq.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              let carts = JSON.parse(this.responseText);

              displayCarts(carts, userData);
            }
          };

          cartsReq.open("POST", "api/carts/fetch_cart.php", true);
          userData = JSON.stringify(userData);
          cartsReq.send(userData);
        }
      }
    };

    userReq.open("GET", "utils/check_user.php", true);
    userReq.send();
  });

  $("#close-btn").click(function () {
    $(".cart-container").toggleClass("open");
    $(".cart-view").toggleClass("open");
    $("body").css("overflow", "scroll");
  });

  $("#checkout-btn").click(function () {
    let checkoutReq = new XMLHttpRequest();

    checkoutReq.open("POST", "api/carts/checkout.php", true);

    checkoutReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let checkoutRes = JSON.parse(this.responseText);

        if (checkoutRes.success) {
          toastr.success(checkoutRes.message, "Success", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
            // Redirect
            onHidden: function () {
              window.location.href = "account.php";
            },
          });
        } else {
          toastr.error(checkoutRes.message, "Failed", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });
        }
      }
    };

    checkoutReq.send(
      JSON.stringify({
        selected_carts: selectedCarts,
      })
    );
  });
}

let subTotal;

let selectedCarts = [];

function displayCarts(carts, user) {
  let container = $(".carts");

  container.empty();

  if (carts.length == 0) {
    let cartEmpty = $("<span>")
      .addClass("cart-empty")
      .text("Your Cart is empty");

    container.append(cartEmpty);

    $("#checkout-btn").prop("disabled", true).addClass("no-hover");
    return;
  }

  $("#checkout-btn").prop("disabled", false).removeClass("no-hover");

  subTotal = 0;

  $.each(carts, function (index, cart) {
    const productId = JSON.stringify({ id: cart.product_id });

    //fetch product
    let productReq = new XMLHttpRequest();

    productReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let product = JSON.parse(this.responseText);

        let cartElement = $("<div>").addClass("cart");

        let checkbox = $("<input>")
          .attr({ type: "checkbox", id: "selected-cart" })
          .prop("checked", true);

        let imageContainer = $("<a>")
          .addClass("image-container")
          .attr("href", "product.php?id=" + product.id);

        let cartImage = $("<img>").attr("src", product.location);

        let cartDetails = $("<div>").addClass("cart-details");
        let cartName = $("<h4>").text(product.name);

        let cartPrice = $("<span>").text(
          "₱ " + product.price.toLocaleString("en-US")
        );

        let quantityContainer = $("<div>").addClass("quantity-container");
        let decreaseQuantity = $("<button>")
          .attr("id", "decrease-quantity")
          .text("-")
          .click(() => {
            if (cart.cart_quantity > 1) {
              updateQuantity("decrease", cart, user);
            }
          });
        let cartQuantity = $("<span>").text(cart.cart_quantity);
        let increaseQuantity = $("<button>")
          .attr("id", "increase-quantity")
          .text("+")
          .click(() => {
            if (cart.cart_quantity < product.quantity) {
              updateQuantity("increase", cart, user);
            }
          });

        let removeBtn = $("<span>")
          .text("Remove Item")
          .attr("id", "remove-btn");

        imageContainer.append(cartImage);

        quantityContainer.append([
          decreaseQuantity,
          cartQuantity,
          increaseQuantity,
        ]);

        cartDetails.append([cartName, cartPrice, quantityContainer, removeBtn]);

        cartElement.append([checkbox, imageContainer, cartDetails]);
        container.append(cartElement);

        let total = 0;

        total = product.price * cart.cart_quantity;

        if (checkbox.prop("checked")) {
          subTotal += total;
          $("#total").text("₱ " + subTotal.toLocaleString("en-US"));

          selectedCarts.push(cart.cart_id);
        }

        checkbox.on("change", function () {
          if ($(this).prop("checked")) {
            subTotal += total;
            $("#total").text("₱ " + subTotal.toLocaleString("en-US"));
            selectedCarts.push(cart.cart_id);
          } else {
            subTotal -= total;
            $("#total").text("₱ " + subTotal.toLocaleString("en-US"));

            let index = selectedCarts.indexOf(cart.cart_id);
            if (index > -1) {
              selectedCarts.splice(index, 1);
            }
          }
        });

        removeBtn.on("click", function () {
          removeItem(cart, user);
        });
      }
    };

    productReq.open("POST", "api/products/fetch_id.php", false);
    productReq.send(productId);
  });
}

function removeItem(cart, user) {
  let removeReq = new XMLHttpRequest();

  removeReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let removeRes = JSON.parse(this.responseText);

      if (removeRes.success == "true") {
        let cartsReq = new XMLHttpRequest();
        cartsReq.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let carts = JSON.parse(this.responseText);

            displayCarts(carts, user);
          }
        };
        cartsReq.open("POST", "api/carts/fetch_cart.php", true);
        cartsReq.send(user);
      }
    }
  };

  removeReq.open("DELETE", "api/carts/remove_id.php", true);
  removeReq.send(JSON.stringify({ id: cart.cart_id }));
}

function updateQuantity(operation, cart, user) {
  let updateData = JSON.stringify({
    operation: operation,
    cart_id: cart.cart_id,
  });

  let updateReq = new XMLHttpRequest();

  updateReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.response);

      let cartsReq = new XMLHttpRequest();
      cartsReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let carts = JSON.parse(this.responseText);

          displayCarts(carts, user);
        }
      };
      cartsReq.open("POST", "api/carts/fetch_cart.php", true);
      cartsReq.send(user);
    }
  };

  updateReq.open("POST", "api/carts/update.php", false);
  updateReq.send(updateData);
}

function dropdownHandler() {
  let dropdown = $(".dropdown");
  let dropdownContainer = $(".dropdown-container");

  dropdown.hide();

  dropdownContainer.hover(
    (event) => {
      let hoveredDropdown = $(event.target).find(".dropdown");
      hoveredDropdown.show();
    },
    (event) => {
      let hoveredDropdown = $(event.target).find(".dropdown");
      hoveredDropdown.hide();
    }
  );

  dropdown.mouseleave(() => {
    dropdown.hide();
  });
}

function slidingTextHandler() {
  // Select the spans
  var emailSpan = $(".text-email");
  var shippingSpan = $(".text-shipping");

  // Hide the shipping span initially
  shippingSpan.hide();

  // Set the interval to switch between spans every 3 seconds
  setInterval(function () {
    if (emailSpan.is(":visible")) {
      shippingSpan.css("right", "0");
      shippingSpan.show();
      shippingSpan.animate({ right: "48%" });

      emailSpan.animate({ left: -10 }, () => {
        emailSpan.hide();
        emailSpan.css("left", "");
      });
    } else {
      emailSpan.css("right", "0");
      emailSpan.show();
      emailSpan.animate({ right: "43%" });

      shippingSpan.animate({ left: -5 }, () => {
        shippingSpan.hide();
        shippingSpan.css("left", "");
        emailSpan.show();
      });
    }
  }, 4000); // 3 seconds interval
}

function userProfileHandler() {
  //pfp and username logic
  let checkUserReq = new XMLHttpRequest();

  checkUserReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let userAuthData = JSON.parse(this.responseText);

      if (userAuthData.loggedIn == "true") {
        let fetchUserReq = new XMLHttpRequest();

        fetchUserReq.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let userData = JSON.parse(this.responseText);

            $(".pfp #username").show().text(userData.username);
            $("#profile-picture").attr("src", userData.profilePicture);
          }
        };

        fetchUserReq.open("POST", "api/users/fetch_id.php", true);
        fetchUserReq.send(JSON.stringify(userAuthData));
      }
    }
  };

  checkUserReq.open("GET", "utils/check_user.php", true);
  checkUserReq.send();
}
