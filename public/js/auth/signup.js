import { showToast } from "../utils/toast.js";

document.addEventListener("DOMContentLoaded", () => {
  const signUpBtn = document.getElementById("buttonSignUp");
  signUpBtn.addEventListener("click", register);
});

async function register() {
  const registerUserId = document.getElementById("SUUserId").value;
  const registerFirstName = document.getElementById("SUFirstName").value;
  const registerMiddleName = document.getElementById("SUMiddleName").value;
  const registerLastName = document.getElementById("SULastName").value;
  const registerEmail = document.getElementById("SUEmail").value;
  const registerPassword = document.getElementById("SUPassword").value;
  const registerRePassword = document.getElementById("SURePassword").value;
  const registerPhoto = document.getElementById("SUPhoto").files[0];

  const errorMessage = document.getElementById("signup-error");
  const successMessage = document.getElementById("signup-message");

  if (!registerPhoto) {
    const errorMsg = "Please upload a profile photo.";
    showToast(errorMsg, "error", 3000);
    return;
  }

  if (registerPhoto.size > 30 * 1024 * 1024) {
    const errorMsg = "File size exceeds 30MB. Please upload a smaller file.";
    showToast(errorMsg, "error", 3000);
    return;
  }

  const formData = new FormData();
  formData.append("registerUserId", registerUserId);
  formData.append("registerFirstName", registerFirstName);
  formData.append("registerMiddleName", registerMiddleName);
  formData.append("registerLastName", registerLastName);
  formData.append("registerEmail", registerEmail);
  formData.append("registerPassword", registerPassword);
  formData.append("registerRePassword", registerRePassword);
  formData.append("registerPhoto", registerPhoto);

  document.getElementById("loadingMessage").style.display = "flex";

  try {
    const res = await fetch("includes/api/signup.api.php", {
      method: "POST",
      body: formData,
    });

    const data = await res.json();
    console.log("Fetch Response:", data);

    const message = data.message;

    if (data.status === "error") {
      showToast(message, "error", 2000);
      document.getElementById("loadingMessage").style.display = "none";
    } else if (data.status === "success") {
      try {
        const emailRes = await fetch("includes/api/email.api.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            action: "register",
            email: registerEmail,
            type: "Student",
            status: "Pending",
          }),
        });

        const emailData = await emailRes.json();

        if (emailData.status === "success") {
          showToast(message, "success", 5000);
        } else {
          showToast(message, "error", 3000);
        }

        document.getElementById("loadingMessage").style.display = "none";
        setTimeout(() => (successMessage.style.display = "none"), 3000);
      } catch (err) {
        console.error("Email API error:", err);
      }

      // Clear form fields
      document.getElementById("SUUserId").value = "";
      document.getElementById("SUFirstName").value = "";
      document.getElementById("SUMiddleName").value = "";
      document.getElementById("SULastName").value = "";
      document.getElementById("SUEmail").value = "";
      document.getElementById("SUPassword").value = "";
      document.getElementById("SURePassword").value = "";
      document.getElementById("SUPhoto").value = "";
    }

    setTimeout(() => {
      errorMessage.style.display = "none";
      successMessage.style.display = "none";
    }, 3000);
  } catch (error) {
    console.error("Fetch Error:", error);
  } finally {
    document.getElementById("SUPassword").value = "";
    document.getElementById("SURePassword").value = "";
  }
}
