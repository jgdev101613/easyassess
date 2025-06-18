const requirementModal = document.getElementById("requirementModal");
const invalidModal = document.getElementById("invalidModal");

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
