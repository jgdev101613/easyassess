$(function () {
  $("#SUPhoto").on("change", function () {
    selectFile();
  });

  // Toggle password visibility
  $(".toggle-password").on("click", function () {
    const targetId = $(this).data("target");
    const input = document.getElementById(targetId);

    const type =
      input.getAttribute("type") === "password" ? "text" : "password";
    input.setAttribute("type", type);

    // jQuery way to toggle icon class
    $(this).toggleClass("fa-eye fa-eye-slash");
  });
});

function selectFile() {
  const fileInput = document.getElementById("SUPhoto");
  const fileName = document.getElementById("fileName");

  if (fileInput.files.length > 0) {
    console.log("Hello");
    fileName.textContent = fileInput.files[0].name;
    fileName.title = fileInput.files[0].name;
  } else {
    fileName.textContent = "No file selected";
  }
}
