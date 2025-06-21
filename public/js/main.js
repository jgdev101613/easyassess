const requirementModal = document.getElementById("requirementModal");
const invalidModal = document.getElementById("invalidModal");

document
  .getElementById("requirementForm")
  .addEventListener("submit", async (e) => {
    e.preventDefault();

    const input = document.getElementById("attachment");
    const departmentId = input.dataset.department;

    const files = input.files;
    if (files.length === 0) {
      alert("Please upload at least one file.");
      return;
    }

    const formData = new FormData();
    formData.append("department_id", departmentId);

    for (let i = 0; i < files.length; i++) {
      formData.append("attachments[]", files[i]);
    }

    try {
      const response = await fetch("includes/api/submit-requirements.api.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();
      if (data.success) {
        alert("Requirements submitted successfully!");
        requirementModal.style.display = "none";
      } else {
        alert("Submission failed: " + (data.message || "Unknown error."));
      }
    } catch (err) {
      console.error("Upload failed:", err);
      alert("Something went wrong. Try again later.");
    }
  });

document.addEventListener("DOMContentLoaded", () => {
  const signInSection = document.querySelector(".section-signin");
  const signUpSection = document.querySelector(".section-signup");
  const linkToSignUp = document.getElementById("linkToSignUp");
  const linkToSignIn = document.getElementById("linkToSignIn");

  // Add basic slide animation using classes
  const slideOut = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateX(-50px)";
    el.style.transition = "all 0.4s ease";
    setTimeout(() => (el.style.display = "none"), 400);
  };

  const slideIn = (el) => {
    el.style.display = "flex";
    el.style.opacity = 0;
    el.style.transform = "translateX(50px)";
    el.style.transition = "none";
    requestAnimationFrame(() => {
      el.style.transition = "all 0.4s ease";
      el.style.opacity = 1;
      el.style.transform = "translateX(0)";
    });
  };

  if (linkToSignUp) {
    linkToSignUp.addEventListener("click", (e) => {
      e.preventDefault();
      slideOut(signInSection);
      setTimeout(() => slideIn(signUpSection), 400);
    });
  }

  if (linkToSignIn) {
    linkToSignIn.addEventListener("click", (e) => {
      e.preventDefault();
      slideOut(signUpSection);
      setTimeout(() => slideIn(signInSection), 400);
    });
  }
});

// Close buttons
document.querySelectorAll(".close-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    requirementModal.style.display = "none";
    invalidModal.style.display = "none";
  });
});

// Close buttons
document.querySelectorAll(".ok-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    requirementModal.style.display = "none";
    invalidModal.style.display = "none";
  });
});

document.addEventListener("DOMContentLoaded", async () => {
  try {
    const response = await fetch(
      "includes/api/fetch-clearance-status.api.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      }
    );

    const data = await response.json();
    if (data.error) throw new Error(data.error);

    const deptStatuses = data;
    let allowNext = true;

    document.querySelectorAll(".clearance-box").forEach((box) => {
      const titleEl = box.querySelector(".clearance-title");
      const deptId = titleEl.dataset.departmentid;

      const deptData = deptStatuses.find((d) => d.department_id === deptId);
      const isApproved = deptData?.status === "approved";
      const needSubmission = deptData?.status === "needs_submission";

      // Allow logic
      if (isApproved) {
        box.setAttribute("data-allowed", "complete");
      } else if (allowNext) {
        box.setAttribute("data-allowed", "true");
        allowNext = false; // only one "true" at a time
      } else {
        box.setAttribute("data-allowed", "false");
      }

      // UI update
      const statusText = box.querySelector(".status p");
      const statusCircle = box.querySelector(".status-circle");

      if (isApproved) {
        statusText.textContent = "Approved";
        statusCircle.classList.remove("pending");
        statusCircle.classList.add("completed");
      } else if (needSubmission) {
        statusText.textContent = "Submit Requirements";
        statusCircle.classList.remove("pending");
        statusCircle.classList.add("need-submission");
      } else {
        statusText.textContent = "Pending";
        statusCircle.classList.remove("completed");
        statusCircle.classList.add("pending");
      }
    });
  } catch (err) {
    console.error("Failed to load clearance status:", err);
  }
});

document.querySelectorAll(".clearance-box").forEach((box) => {
  box.addEventListener("click", async () => {
    const canAccess = box.getAttribute("data-allowed") === "true";
    const department =
      box.querySelector(".clearance-title").dataset.departmentid;

    const departmentName = box
      .querySelector(".clearance-title")
      .textContent.trim();

    const allowedState = box.getAttribute("data-allowed");

    if (allowedState === "true") {
      // Set modal content
      document.querySelector("#attachment").dataset.department = department;
      requirementModal.querySelector(
        "h2"
      ).textContent = `Submit Requirements to ${departmentName}`;

      // Fetch remarks
      try {
        const response = await fetch("includes/api/fetch-remarks.api.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ department }),
        });

        const data = await response.json();
        const remarks = data?.remarks || "No remarks available.";
        document.getElementById("clearance-remarks").textContent = remarks;
      } catch (error) {
        console.error("Failed to fetch remarks:", error);
        document.getElementById("clearance-remarks").textContent =
          "Error loading remarks.";
      }

      requirementModal.style.display = "block";
    } else if (allowedState === "false") {
      invalidModal.style.display = "block";
    }

    // If allowedState === "complete" — do nothing
  });
});

// Optional: close when clicking outside
window.addEventListener("click", (e) => {
  if (e.target === requirementModal) requirementModal.style.display = "none";
  if (e.target === invalidModal) invalidModal.style.display = "none";
});
