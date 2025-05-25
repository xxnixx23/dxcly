$(document).ready(function () {
  $("#login-button").click(() => {
    if (!$(".login")[0].checkValidity()) {
      $(".login")[0].reportValidity();
      return;
    }

    // ✅ Check if CAPTCHA was solved
    const recaptcha = grecaptcha.getResponse();
    if (!recaptcha) {
      toastr.error("Please complete the CAPTCHA.", "Warning", {
        timeOut: 2000,
        preventDuplicates: true,
        positionClass: "toast-bottom-left",
      });
      return;
    }

    let email = $("#email").val();
    let password = $("#password").val();

    let loginData = JSON.stringify({
      email: email,
      password: password,
      recaptcha: recaptcha, // send token to backend
    });

    var loginReq = new XMLHttpRequest();
    loginReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let loginRes = JSON.parse(this.responseText);

        if (loginRes.success == "true") {
          toastr.success(loginRes.message, "Success", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
            onHidden: function () {
              if (loginRes.accountType == "admin") {
                location.replace("dashboard.php");
              } else {
                let logReq = new XMLHttpRequest();
                logReq.onreadystatechange = function () {
                  if (this.readyState == 4 && this.status == 200) {
                    location.replace("index.php");
                  }
                };

                logReq.open("POST", "api/logs/add.php", true);
                logReq.send(
                  JSON.stringify({
                    userId: loginRes.userId,
                    action: "Login",
                    username: loginRes.username,
                  })
                );
              }
            },
          });
        } else {
          toastr.error(loginRes.message, "Failed", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });

          // Reset CAPTCHA if login failed
          grecaptcha.reset();
        }
      }
    };
    loginReq.open("POST", "api/auth/login.php", true);
    loginReq.setRequestHeader("Content-Type", "application/json");
    loginReq.send(loginData);
  });

  $("#verify-button").click(() => {
    if (!$(".verify")[0].checkValidity()) {
      $(".verify")[0].reportValidity();
      return;
    }

    let email = JSON.stringify($("#email-verify").val());

    let findEmailReq = new XMLHttpRequest();
    findEmailReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let findEmailRes = JSON.parse(this.responseText);

        if (findEmailRes.success == true) {
          window.location.href =
            "reset_password.php?id=$2y$10" + findEmailRes.id + "./1TcIo92zG";
        } else {
          toastr.error(findEmailRes.message, "Failed", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });
        }
      }
    };

    findEmailReq.open("POST", "utils/find_user.php", true);
    findEmailReq.send(email);
  });

  $("#show-password").hover(() => {
    $("#password").attr("type") == "password"
      ? $("#password").attr("type", "text")
      : $("#password").attr("type", "password");
  });

  const urlParams = new URLSearchParams(window.location.search);
  const forgotParam = urlParams.get("change");
  const forgot = forgotParam === "true" ? true : false;

  $("#forgot-password").click(() => {
    window.location.href = "login.php?change=true";
  });

  if (forgot) {
    $(".login").css("display", "none");
    $(".verify").css("display", "flex");
  }

  $(".cancel").click(() => {
    window.location.href = "login.php";
  });

  // ✅ Simplified "Send Code" handler (fake toast only)
  // 📧 Actual "Send Code" request to backend
  $("#send-code").click(() => {
    let email = $("#email-verify").val();

    if (!email) {
      toastr.error("Please enter your email.", "Error", {
        timeOut: 2000,
        preventDuplicates: true,
        positionClass: "toast-bottom-left",
      });
      return;
    }

    $.ajax({
      url: "utils/send_code.php",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ email: email }),
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });
        } else {
          toastr.error(response.message, "Error", {
            timeOut: 2000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          });
        }
      },
      error: function (xhr, status, error) {
        toastr.error(
          "Something went wrong: " + xhr.responseText,
          "Server Error",
          {
            timeOut: 3000,
            preventDuplicates: true,
            positionClass: "toast-bottom-left",
          }
        );
      },
    });
  });
});
