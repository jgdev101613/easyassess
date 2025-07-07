import { navigation } from "./navigation.js";
import { showToast } from "./toast.js";
// When profile page is loaded fetch the necessary data
document.addEventListener("DOMContentLoaded", () => {
  navigation();

  const userId = getUserId();
  if (!userId) {
    console.error("User ID is missing.");
    return;
  }

  fetchUserProfile(userId);

  // Change profile
  document
    .getElementById("photoInput")
    .addEventListener("change", async function () {
      const file = this.files[0];
      const userId = getUserId();

      if (file && userId) {
        // Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("profileImage").src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Prepare form data
        const formData = new FormData();
        formData.append("profileImage", file);
        formData.append("userId", userId);

        try {
          const res = await fetch("includes/api/upload-profile-image.api.php", {
            method: "POST",
            body: formData,
          });

          const result = await res.json();
          if (result.status === "success") {
            showToast("Profile photo updated!", "success");
          } else {
            showToast(result.message, "error");
          }
        } catch (err) {
          console.error("Upload error:", err);
          showToast("Image upload failed.", "error");
        }
      }
    });
});

// Get User Id From Body
function getUserId() {
  const container = document.querySelector("[data-userid]");
  return container?.dataset.userid || null;
}

// Fetch the data from API
async function fetchUserProfile(userId) {
  try {
    const response = await fetch(
      `includes/api/fetch-user-info.api.php?user_id=${encodeURIComponent(
        userId
      )}`
    );
    const result = await response.json();

    if (result.status === "success") {
      console.log(result);
      populateProfileForm(result.data);
    } else {
      console.warn(result.message);
    }
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
}

// Populate the fields
function populateProfileForm(data) {
  const fullName =
    data.first_name + " " + data.middle_name + " " + data.last_name;
  // Profile
  document.getElementById("userName").textContent = fullName;
  document.getElementById("userStatus").textContent = data.status;
  document.getElementById("profileImage").src =
    data.profile_image || "assets/default-profile.jpg";

  // Form (input) values
  document.querySelector("input[placeholder='First Name']").value =
    data.first_name || "";
  document.querySelector("input[placeholder='Middle Name']").value =
    data.middle_name || "";
  document.querySelector("input[placeholder='Last Name']").value =
    data.last_name || "";
  document.querySelector("input[placeholder='Email']").value = data.email || "";
  document.querySelector("input[placeholder='Department']").value =
    data.prog_department_id || data.department || "N/A";

  // Profile Details
  document.getElementById("userIdText").textContent = data.user_id ?? "";
  document.getElementById("studentIdText").textContent =
    data.student_id || data.id || "";
  document.getElementById("firstNameText").textContent = data.first_name || "";
  document.getElementById("middleNameText").textContent =
    data.middle_name || "";
  document.getElementById("lastNameText").textContent = data.last_name || "";
  document.getElementById("emailText").textContent = data.email || "";
  document.getElementById("departmentText").textContent =
    data.prog_department_id || data.department || "N/A";

  // Show/hide fields based on user type
  if (data.user_type === "student") {
    // Show student fields
    document.querySelectorAll(".student-only").forEach((el) => {
      el.style.display = "flex";
    });
    document.querySelectorAll(".professor-only").forEach((el) => {
      el.style.display = "none";
    });

    // Populate student-only fields
    document.getElementById("courseText").textContent = data.course || "N/A";
    document.getElementById("yearText").textContent = data.year_level || "N/A";
    document.getElementById("sectionText").textContent = data.section || "N/A";
    document.querySelector("input[placeholder='Course']").value =
      data.course || "N/A";
    document.querySelector("input[placeholder='Year']").value =
      data.year_level || "N/A";
    document.querySelector("input[placeholder='Section']").value =
      data.section || "N/A";
  } else if (data.user_type === "professor") {
    // Hide student fields
    document.querySelectorAll(".student-only").forEach((el) => {
      el.style.display = "none";
    });
    document.querySelectorAll(".professor-only").forEach((el) => {
      el.style.display = "flex";
    });

    // Optional: If you have `position`, set it here
    document.getElementById("positionText").textContent = data.position; // or data.position
  }
}

document.getElementById("editProfileBtn").addEventListener("click", () => {
  document.getElementById("editProfileModal").style.display = "block";
});

document.getElementById("closeProfileModal").addEventListener("click", () => {
  document.getElementById("editProfileModal").style.display = "none";
});

window.addEventListener("click", (e) => {
  const profileModal = document.getElementById("editProfileModal");
  if (e.target === profileModal) profileModal.style.display = "none";
});

document.getElementById("editPhotoBtn").addEventListener("click", () => {
  document.getElementById("photoInput").click();
});

document.getElementById("photoInput").addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("profileImage").src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

// document.getElementById("changePasswordBtn").addEventListener("click", () => {
//   document.getElementById("changePasswordModal").style.display = "block";
// });

// document.getElementById("closePasswordModal").addEventListener("click", () => {
//   document.getElementById("changePasswordModal").style.display = "none";
// });

// View full profile photo
document.getElementById("profileImage").addEventListener("click", () => {
  const modal = document.getElementById("viewImageModal");
  const fullImage = document.getElementById("fullImagePreview");
  fullImage.src = document.getElementById("profileImage").src;
  modal.style.display = "block";
});

document.getElementById("closeImageModal").addEventListener("click", () => {
  document.getElementById("viewImageModal").style.display = "none";
});
