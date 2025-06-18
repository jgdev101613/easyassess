import { showToast } from "../utils/toast.js";

document.addEventListener("DOMContentLoaded", () => {
  const btnSignIn = document.getElementById("buttonSignIn");
  const btnSignOut = document.getElementById("buttonSignOut");
  const btnSignUp = document.getElementById("buttonSignUp");

  btnSignIn.addEventListener("click", () => {
    console.log("Sign In Button Clicked");
    signIn();
  });

  btnSignUp.addEventListener("click", () => {
    console.log("Sign Up Button Clicked");
    signUp();
  });

  if (btnSignOut) {
    btnSignOut.addEventListener("click", () => {
      console.log("Sign Out Button Clicked");
      signOut();
    });
  }
});

async function signIn() {
  const signinUserId = document.getElementById("SIUserId").value;
  const signinPassword = document.getElementById("SIPassword").value;
  const errorMessage = document.getElementById("errorMessage");

  // Reset borders
  document.getElementById("StudentIDGroup").style.border = "";
  document.getElementById("StudentPasswordGroup").style.border = "";

  let hasError = false;

  if (signinUserId === "") {
    document.getElementById("StudentIDGroup").style.border = "1px solid red";
    hasError = true;
  }

  if (signinPassword === "") {
    document.getElementById("StudentPasswordGroup").style.border =
      "1px solid red";
    hasError = true;
  }

  if (hasError) return;

  // Show loading
  document.getElementById("loadingMessage").style.display = "flex";

  try {
    const res = await fetch("includes/api/signin.api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        signinUserId,
        signinPassword,
      }),
    });

    const data = await res.json();
    console.log("Fetch Response:", data);

    const message = data.message;

    if (data.status === "success") {
      showToast(message, "success", 2000);
      setTimeout(() => {
        window.location.href = "auth/dashboard.php";
      }, 2000);
    } else if (data.status === "warning") {
      showToast(message, "warning", 5000);
    } else if (data.status === "error") {
      showToast(message, "error", 4000);
    }

    setTimeout(() => {
      errorMessage.style.display = "none";
    }, 3000);
  } catch (err) {
    console.error("Fetch Error:", err);
  } finally {
    document.getElementById("loadingMessage").style.display = "none";
  }
}

async function signOut() {
  try {
    const res = await fetch("includes/signout/signout.inc.php");
    const data = await res.text();

    console.log("Fetch Response:", data);

    const signinMessage = document.getElementById("signinMessage");
    if (signinMessage) {
      signinMessage.innerHTML = data;
      signinMessage.style.display = "block";
    }

    let parsedData;
    try {
      parsedData = JSON.parse(data);
      console.log(parsedData.message);
    } catch (err) {
      console.warn("Response was not JSON:", err);
    }

    if (data.includes("Logged out successfully!")) {
      window.location = "index.php";
    }
  } catch (err) {
    console.error("Fetch Error:", err);
  }
}

async function signUp() {
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
