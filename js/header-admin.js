$(document).ready(function () {
  let lastScrollTop = 0;
  let header = $(".header");

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
      } else {
        header.css("height", "10vh"); // Set the minimized height for other scroll positions
        header.css("justify-content", "center");
      }
    }
    lastScrollTop = st;
  });

  $("#logout-button").click(logoutHandler);

  dropdownHandler();
});

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

function logoutHandler() {
  let logoutReq = new XMLHttpRequest();

  logoutReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let logoutRes = JSON.parse(this.responseText);

      if (logoutRes.success == "true") {
        window.location.href = "login.php";
      }
    }
  };

  logoutReq.open("DELETE", "api/auth/logout.php", true);
  logoutReq.send();
}
