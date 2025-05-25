$(document).ready(function () {
  $("#reset-button").click(() => {
    if (!$(".reset")[0].checkValidity()) {
      $(".reset")[0].reportValidity();
      return;
    }

    //get url params
    const urlParams = new URLSearchParams(window.location.search);
    let id = urlParams.get("id");

    id = id.substring(6);

    let changeReq = new XMLHttpRequest();

    changeReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let changeRes = JSON.parse(this.responseText);

        if (changeRes.success == true) {
          toastr.success(changeRes.message, "Success", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
            onHidden: () => {
              let logReq = new XMLHttpRequest();

              logReq.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                  window.location.replace("login.php");
                }
              };

              logReq.open("POST", "api/logs/add.php", true);
              logReq.send(
                JSON.stringify({
                  userId: id,
                  action: "Change Password",
                  username: changeRes.username,
                })
              );
            },
          });
        } else {
          toastr.error(changeRes.message, "Failed", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });
        }
      }
    };

    changeReq.open("POST", "api/users/reset_password.php", true);
    changeReq.send(
      JSON.stringify({ id: id, password: $("#new-password").val() })
    );
  });
  $("#new-password").on("input", function () {
    if ($("#new-password").val() == "") {
      $("#password-match").text("").css();
      $("#reset-button").prop("disabled", true).addClass("no-hover");
    }

    if ($("#new-password").val() == $("#confirm-password").val()) {
      $(".input-password").css("justify-content", "space-between");
      $("#password-match").text("Password match").css("color", "green");

      $("#reset-button").prop("disabled", false).removeClass("no-hover");
    } else {
      $(".input-password").css("justify-content", "space-between");
      $("#password-match").text("Password does not match").css("color", "red");
      $("#reset-button").prop("disabled", true).addClass("no-hover");
    }
  });

  $("#confirm-password").on("input", function () {
    if ($("#confirm-password").val() == "") {
      $("#password-match").text("").css();
      $("#reset-button").prop("disabled", true).addClass("no-hover");
    }

    if ($("#new-password").val() == $("#confirm-password").val()) {
      $(".input-password").css("justify-content", "space-between");
      $("#password-match").text("Password match").css("color", "green");

      $("#reset-button").prop("disabled", false).removeClass("no-hover");
    } else {
      $(".input-password").css("justify-content", "space-between");
      $("#password-match").text("Password does not match").css("color", "red");
      $("#reset-button").prop("disabled", true).addClass("no-hover");
    }
  });

  $("#reset-button").prop("disabled", true).addClass("no-hover");

  $("#show-password").hover(() => {
    $("#new-password").attr("type") == "password"
      ? $("#new-password").attr("type", "text")
      : $("#new-password").attr("type", "password");
  });

  $("#show-confirm-password").hover(() => {
    $("#confirm-password").attr("type") == "password"
      ? $("#confirm-password").attr("type", "text")
      : $("#confirm-password").attr("type", "password");
  });
});
