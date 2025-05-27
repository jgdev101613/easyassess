$(function () {
  // Listen to register button
  $("#togglePassword").on("click", function () {
    togglePasswordVisibility();
  });
});

function togglePasswordVisibility() {
  // Log when the function is called
  console.log("Toggle Password Visibility function called");
  const passwordInput = document.getElementById("SIStudentPassword");
  const toggleIcon = document.getElementById("togglePassword");

  // Toggle the type attribute
  const type =
    passwordInput.getAttribute("type") === "password" ? "text" : "password";
  passwordInput.setAttribute("type", type);

  // Toggle the eye / eye-slash icon
  toggleIcon.classList.toggle("fa-eye-slash");
  toggleIcon.classList.toggle("fa-eye");
}

// Just a sample notification function
function notifyMe() {
  // Check if browser supports notifications
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  } else if (Notification.permission === "granted") {
    new Notification("Hey there! 👋 This is your notification.");
  } else if (Notification.permission !== "denied") {
    Notification.requestPermission().then((permission) => {
      if (permission === "granted") {
        new Notification("You have allowed notifications!");
      }
    });
  }
}
