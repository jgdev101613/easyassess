// toast.js
window.showToast = function (message, type = "info", duration) {
  let bgColor;

  switch (type) {
    case "success":
      bgColor = "#3fae60";
      break;
    case "error":
      bgColor = "#d63737";
      break;
    case "warning":
      bgColor = "#f1c40f";
      break;
    default:
      bgColor = "#3498db";
  }

  Toastify({
    text: message,
    duration: duration,
    gravity: "bottom",
    position: "right",
    stopOnFocus: true,
    close: false,
    style: {
      background: bgColor,
      borderRadius: "20px",
    },
  }).showToast();
};
