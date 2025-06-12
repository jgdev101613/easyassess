const requirementModal = document.getElementById("requirementModal");
const invalidModal = document.getElementById("invalidModal");

// Close buttons
document.querySelectorAll(".close-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    requirementModal.style.display = "none";
    invalidModal.style.display = "none";
  });
});

// OK button for invalid modal
document.querySelector(".ok-btn").addEventListener("click", () => {
  invalidModal.style.display = "none";
});

// Example logic for each clearance box
document.querySelectorAll(".clearance-box").forEach((box) => {
  box.addEventListener("click", () => {
    // Placeholder: Replace with actual logic
    const canAccess = box.getAttribute("data-allowed") === "true";

    if (canAccess) {
      requirementModal.style.display = "block";
    } else if (!canAccess) {
      invalidModal.style.display = "block";
    }
  });
});

// Optional: close when clicking outside
window.addEventListener("click", (e) => {
  if (e.target === requirementModal) requirementModal.style.display = "none";
  if (e.target === invalidModal) invalidModal.style.display = "none";
});
