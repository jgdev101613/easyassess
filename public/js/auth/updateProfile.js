import { showToast } from "../utils/toast.js";

document.addEventListener("DOMContentLoaded", () => {
  const editForm = document.getElementById("editProfileForm");

  editForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    await updateProfile();
  });
});

async function updateProfile() {
  const inputs = document.querySelectorAll("#editProfileForm input");

  const formData = new URLSearchParams();
  inputs.forEach((input) => {
    formData.append(
      input.placeholder.replace(" ", "").toLowerCase(),
      input.value.trim()
    );
  });

  try {
    const res = await fetch("includes/api/edit-profile.api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: formData,
    });

    const data = await res.json();
    console.log("Fetch Response:", data);

    if (data.status === "success") {
      showToast(data.message, "success", 3000);
      setTimeout(() => {
        location.reload(); // or close modal manually
      }, 2000);
    } else if (data.status === "warning") {
      showToast(data.message, "warning", 5000);
    } else {
      showToast(data.message, "error", 4000);
    }
  } catch (err) {
    console.error("Fetch Error:", err);
    showToast("Something went wrong. Try again.", "error", 4000);
  }
}
