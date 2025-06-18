document.addEventListener("DOMContentLoaded", () => {
  const photoInput = document.getElementById("SUPhoto");
  const toggleButtons = document.querySelectorAll(".toggle-password");

  if (photoInput) {
    photoInput.addEventListener("change", selectFile);
  }

  toggleButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.dataset.target;
      const input = document.getElementById(targetId);

      if (input) {
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        button.classList.toggle("fa-eye");
        button.classList.toggle("fa-eye-slash");
      }
    });
  });
});

function selectFile() {
  const fileInput = document.getElementById("SUPhoto");
  const fileName = document.getElementById("fileName");

  if (fileInput && fileName) {
    if (fileInput.files.length > 0) {
      const name = fileInput.files[0].name;
      fileName.textContent = name;
      fileName.title = name;
    } else {
      fileName.textContent = "No file selected";
      fileName.title = "";
    }
  }
}
