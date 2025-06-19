document.querySelectorAll(".notification-card").forEach((card) => {
  card.addEventListener("click", () => {
    document.getElementById("notifTitle").textContent = card.dataset.title;
    document.getElementById("notifMessage").textContent = card.dataset.message;
    document.getElementById("notifDate").textContent = card.dataset.date;
    document.getElementById("notificationModal").style.display = "block";
  });
});

document
  .getElementById("closeNotificationModal")
  .addEventListener("click", () => {
    document.getElementById("notificationModal").style.display = "none";
  });

window.addEventListener("click", (e) => {
  if (e.target === document.getElementById("notificationModal")) {
    document.getElementById("notificationModal").style.display = "none";
  }
});
