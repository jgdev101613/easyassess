import { navigation } from "./navigation.js";

document.addEventListener("DOMContentLoaded", async () => {
  navigation();
  const list = document.querySelector(".notifications-list");

  try {
    const res = await fetch("includes/api/fetch-notifications.api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const notifications = await res.json();

    if (notifications.error) throw new Error(notifications.error);

    list.innerHTML = ""; // clear static cards

    notifications.forEach((notif) => {
      const card = document.createElement("div");
      card.classList.add("notification-card");
      card.dataset.title = notif.title;
      card.dataset.message = notif.message;
      card.dataset.date = notif.created_at;
      card.dataset.read = notif.is_read; // This is important

      const iconClass = getNotificationIcon(notif.title);

      card.innerHTML = `
        <div class="icon"><i class="${iconClass}"></i></div>
        <div class="details">
          <div class="message">${notif.title}</div>
          <div class="date">${notif.created_at}</div>
        </div>
      `;

      document.querySelector(".notifications-list").appendChild(card);

      card.addEventListener("click", async () => {
        // Open modal
        document.getElementById("notifTitle").textContent = card.dataset.title;
        document.getElementById("notifMessage").textContent =
          card.dataset.message;
        document.getElementById("notifDate").textContent = card.dataset.date;
        document.getElementById("notificationModal").style.display = "block";

        if (card.dataset.read === "0") {
          try {
            await fetch("includes/api/mark-read.api.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ notificationId: notif.id }),
            });

            // Update UI
            card.dataset.read = "1";
            card.classList.remove("unread"); // optional
            card.style.fontWeight = "normal";
          } catch (err) {
            console.error("Failed to mark as read:", err);
          }
        }
      });

      list.appendChild(card);
    });
  } catch (err) {
    console.error("Failed to fetch notifications", err);
  }
});

function getNotificationIcon(title) {
  title = title.toLowerCase(); // case-insensitive

  if (title.includes("activated")) return "fas fa-user-check";
  if (title.includes("reminder")) return "fas fa-bell";
  if (title.includes("book")) return "fas fa-book";
  if (title.includes("rejected")) return "fas fa-times-circle";
  if (title.includes("clearance")) return "fas fa-clipboard-check";
  if (title.includes("signature")) return "fas fa-pen";
  if (title.includes("account")) return "fas fa-user";

  // Default icon
  return "fas fa-info-circle";
}

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

function formatDate(dateString) {
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "2-digit",
    hour12: true,
  };
  return new Date(dateString).toLocaleString("en-US", options);
}
