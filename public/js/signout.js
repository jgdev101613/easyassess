$(function () {
  // Listen to register button
  $("#buttonSignOut").on("click", function () {
    console.log("Sign In function called");
    signOut();
  });
});

function signOut() {
  $.ajax({
    url: "includes/signout/signout.inc.php",
    success: function (data) {
      console.log("AJAX Response:", data); // Log the response
      $("#signinMessage").html(data).fadeIn();

      // Parse the JSON string into a JavaScript object
      var parsedData = JSON.parse(data);

      console.log(parsedData.message);

      if (data.indexOf("Logged out successfully!") >= 0) {
        window.location = "index.php";
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error: ", textStatus, errorThrown); // Log any errors
    },
  });
}
