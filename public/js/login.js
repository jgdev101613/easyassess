// Login
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
