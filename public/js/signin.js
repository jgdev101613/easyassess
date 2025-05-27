$(function () {
  // Listen to register button
  $("#buttonSignIn").on("click", function () {
    console.log("Sign In function called");
    signin();
  });
});

function signin() {
  // Log when the function is called
  var signinStudentId = $("#SIStudentID").val();
  var signinStudentPassword = $("#SIStudentPassword").val();

  // Loading
  $("#loadingMessage").fadeIn();

  $.ajax({
    url: "includes/signin/signin.inc.php",
    method: "POST",
    data: {
      signinStudentId: signinStudentId,
      signinStudentPassword: signinStudentPassword,
    },
    success: function (data) {
      console.log("AJAX Response:", data); // Log the response
      $("#errorMessage").html(data).fadeIn();

      // Parse the JSON string into a JavaScript object
      var parsedData = JSON.parse(data);

      console.log(parsedData.message);

      setTimeout(function () {
        $("#errorMessage").fadeOut();
      }, 60000);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error: ", textStatus, errorThrown); // Log any errors
    },
    complete: function () {
      // Hide the loading message once the request is complete
      $("#loadingMessage").fadeOut();

      // Remove the value of the input fields
      $("#SIStudentID").val("");
      $("#SIStudentPassword").val("");
    },
  });
}
