$(function () {
  // Listen to register button
  $("#buttonSignIn").on("click", function () {
    console.log("Sign In function called");
    signin();
  });
});

function signin() {
  // Log when the function is called
  var signinUserId = $("#SIUserId").val();
  var signinPassword = $("#SIPassword").val();
  var errorMessage = $("#errorMessage");

  // Reset borders first
  $("#StudentIDGroup, #StudentPasswordGroup").css("border", "");

  let hasError = false;

  if (signinUserId === "") {
    $("#StudentIDGroup").css("border", "1px solid red");
    hasError = true;
  }

  if (signinPassword === "") {
    $("#StudentPasswordGroup").css("border", "1px solid red");
    hasError = true;
  }

  if (hasError) {
    return; // Stop if there are empty fields
  }

  // Loading
  $("#loadingMessage").fadeIn();

  $.ajax({
    url: "includes/api/signin.api.php",
    method: "POST",
    data: {
      signinUserId: signinUserId,
      signinPassword: signinPassword,
    },
    dataType: "json",
    success: function (data) {
      console.log("AJAX Response:", data);
      var message = data.message; // Log the response

      if (data.status === "success") {
        showToast(message, "success", 2000);
        setTimeout(() => {
          window.location.href = "auth/dashboard.php";
        }, 2000); // Wait 2 seconds (same as toast duration)
      } else if (data.status === "warning") {
        showToast(message, "warning", 5000);
      } else if (data.status === "error") {
        showToast(message, "error", 4000);
      }

      setTimeout(function () {
        errorMessage.fadeOut();
      }, 3000);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error: ", textStatus, errorThrown); // Log any errors
    },
    complete: function () {
      // Hide the loading message once the request is complete
      $("#loadingMessage").fadeOut();
    },
  });
}
