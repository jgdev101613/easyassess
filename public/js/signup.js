$(function () {
  // Listen to register button
  $("#buttonSignUp").on("click", function () {
    console.log("Register function called");
    register();
  });
});

function register() {
  // Log when the function is called
  var registerStudentID = $("#SUStudentID").val();
  var registerStudentFirstName = $("#SUStudentFirstName").val();
  var registerStudentMiddleName = $("#SUStudentMiddleName").val();
  var registerStudentLastName = $("#SUStudentLastName").val();
  var regsterStudentEmail = $("#SUStudentEmail").val();
  var registerStudentPassword = $("#SUStudentPassword").val();
  var registerStudentRePassword = $("#SUStudentRePassword").val();

  // Loading
  $("#loadingMessage").fadeIn();

  $.ajax({
    url: "includes/signup/signup.inc.php",
    method: "POST",
    data: {
      registerStudentID: registerStudentID,
      registerStudentFirstName: registerStudentFirstName,
      registerStudentMiddleName: registerStudentMiddleName,
      registerStudentLastName: registerStudentLastName,
      regsterStudentEmail: regsterStudentEmail,
      registerStudentPassword: registerStudentPassword,
      registerStudentRePassword: registerStudentRePassword,
    },
    success: function (data) {
      console.log("AJAX Response:", data); // Log the response
      $("#registerMessage").html(data).fadeIn();

      // Parse the JSON string into a JavaScript object
      var parsedData = JSON.parse(data);

      console.log(parsedData.message);

      setTimeout(function () {
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
      $("#SUStudentPassword").val("");
      $("#SUStudentRePassword").val("");
    },
  });
}
