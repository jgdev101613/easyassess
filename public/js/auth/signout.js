document.addEventListener("DOMContentLoaded", () => {
  const buttonSignOut = document.getElementById("buttonSignOut");

  if (buttonSignOut) {
    buttonSignOut.addEventListener("click", () => {
      console.log("Sign Out function called");
      signOut();
    });
  }
});

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
