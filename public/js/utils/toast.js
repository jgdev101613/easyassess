// toast.js
export function showToast(
  message,
  type = "info",
  duration = 3000,
  gravity = "bottom",
  position = "right"
) {
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
    gravity: gravity,
    position: position,
    stopOnFocus: true,
    close: false,
    style: {
      background: bgColor,
      borderRadius: "20px",
      padding: "1rem 1.5rem",
      fontSize: "14px",
      maxWidth: "90%", // prevent overflow
      wordBreak: "break-word", // allow text to wrap
      textAlign: "center",
    },
  }).showToast();
}
