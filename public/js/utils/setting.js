import { navigation } from "./navigation.js";

document.addEventListener("DOMContentLoaded", async () => {
  navigation();
});

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
