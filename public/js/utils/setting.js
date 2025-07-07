import { navigation } from "./navigation.js";
import { showToast } from "./toast.js";

document.addEventListener("DOMContentLoaded", async () => {
  navigation();
  const resetPasswordBtn = document.getElementById("buttonUpdatePassword");

  if (resetPasswordBtn) {
    resetPasswordBtn.addEventListener("click", (e) => {
      e.preventDefault();
      console.log("Update Password Button Clicked");
      resetPassword();
    });
  }
});

async function resetPassword() {
  const userId = document.getElementById("userId").value;
  const currentPasswordInput = document.getElementById("currentPassword");
  const newPasswordInput = document.getElementById("newPassword");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  const currentPassword = currentPasswordInput.value;
  const newPassword = newPasswordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  try {
    const res = await fetch("includes/api/reset-password.api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        userId,
        currentPassword,
        newPassword,
        confirmPassword,
      }),
    });

    const data = await res.json();

    const message = data.message;

    if (data.status === "success") {
      showToast(message, "success", 2000);
    } else if (data.status === "warning") {
      showToast(message, "warning", 5000);
    } else if (data.status === "error") {
      showToast(message, "error", 4000);
    }
  } catch (err) {
    console.error("Fetch Error:", err);
  } finally {
    currentPasswordInput.value = "";
    newPasswordInput.value = "";
    confirmPasswordInput.value = "";
    document.getElementById("passwordModal").style.display = "none";
  }
}

// MODALS
document.getElementById("openPasswordModal").addEventListener("click", () => {
  document.getElementById("passwordModal").style.display = "block";
});

document.getElementById("closePasswordModal").addEventListener("click", () => {
  document.getElementById("passwordModal").style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === document.getElementById("passwordModal")) {
    document.getElementById("passwordModal").style.display = "none";
  }
});
