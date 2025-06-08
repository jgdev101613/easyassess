$(function () {
  // Listen to register button
  $("#buttonSignUp").on("click", function () {
    register();
  });
});

function register() {
  // Log when the function is called
  var registerUserId = $("#SUUserId").val();
  var registerFirstName = $("#SUFirstName").val();
  var registerMiddleName = $("#SUMiddleName").val();
  var registerLastName = $("#SULastName").val();
  var registerEmail = $("#SUEmail").val();
  var registerPassword = $("#SUPassword").val();
  var registerRePassword = $("#SURePassword").val();
  var registerPhoto = $("#SUPhoto")[0].files[0];
  var errorMessage = $("#signup-error");

  if (!registerPhoto) {
    $("#signup-error").html("Please upload a profile photo.").fadeIn();

    setTimeout(function () {
      $("#signup-error").fadeOut();
    }, 3000);
    return;
  }

  // Check file size (max 30MB)
  if (registerPhoto && registerPhoto.size > 30 * 1024 * 1024) {
    setTimeout(function () {
      $("#errorMessage")
        .html("File size exceeds 30MB. Please upload a smaller file.")
        .fadeIn();
    }, 3000);
    return;
  }

  var formData = new FormData();
  formData.append("student_photo", registerUserId);
  formData.append("registerFirstName", registerFirstName);
  formData.append("registerMiddleName", registerMiddleName);
  formData.append("registerLastName", registerLastName);
  formData.append("registerEmail", registerEmail);
  formData.append("registerPassword", registerPassword);
  formData.append("registerRePassword", registerRePassword);
  formData.append("registerPhoto", registerPhoto);

  // Loading
  $("#loadingMessage").fadeIn();

  $.ajax({
    url: "includes/api/signup.inc.php",
    method: "POST",
    data: formData,
    contentType: false, // Important for file uploads
    processData: false, // Important for file uploads
    dataType: "json",
    success: function (data) {
      console.log("AJAX Response:", data); // Log the response
      // $("#registerMessage").html(data).fadeIn();

      if (data.status === "error") {
        errorMessage.html(data.message).fadeIn();
      }

      setTimeout(function () {
        errorMessage.fadeOut();
        $("#registerMessage").fadeOut();
      }, 2000);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error: ", textStatus, errorThrown); // Log any errors
    },
    complete: function () {
      // Hide the loading message once the request is complete
      $("#loadingMessage").fadeOut();

      // Remove the value of the password input fields
      $("#SUPassword").val("");
      $("#SURePassword").val("");
    },
  });
}
