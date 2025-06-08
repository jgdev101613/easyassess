$(function () {});

// Just a sample notification function
function notifyMe() {
  // Check if browser supports notifications
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  } else if (Notification.permission === "granted") {
    new Notification("Hey there! 👋 This is your notification.");
  } else if (Notification.permission !== "denied") {
    Notification.requestPermission().then((permission) => {
      if (permission === "granted") {
        new Notification("You have allowed notifications!");
      }
    });
  }
}
