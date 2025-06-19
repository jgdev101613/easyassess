<?php
require_once "includes/session/config.session.inc.php";

if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Easy Assess - Notifications</title>

  <link rel="stylesheet" href="public/css/main.css">
  <link rel="stylesheet" href="public/css/component.css">
  <link rel="stylesheet" href="public/css/notification.css">
  <link rel="icon" href="assets/saclilogo.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <?php include_once "includes/components/header.html"; ?>

  <div class="container">
    <!-- <h2 class="section-title">Notifications</h2> -->

    <div class="notifications-list">
      <!-- Example Notification -->
      <div class="notification-card" data-title="Account Approved" data-message="Congratulations! Your student account has been approved by the admin." data-date="June 18, 2025 10:32 AM">
        <div class="icon"><i class="fas fa-user-check"></i></div>
        <div class="details">
          <div class="message">Your account has been approved</div>
          <div class="date">June 18, 2025</div>
        </div>
      </div>

      <div class="notification-card" data-title="Library Reminder" data-message="You have books due next week. Please return them before June 25 to avoid penalty." data-date="June 17, 2025 2:45 PM">
        <div class="icon"><i class="fas fa-book"></i></div>
        <div class="details">
          <div class="message">Reminder: Book due soon</div>
          <div class="date">June 17, 2025</div>
        </div>
      </div>

      <!-- Add more notification cards dynamically via PHP or JS -->
    </div>
  </div>

  <!-- Notification Modal -->
  <div class="modal" id="notificationModal">
    <div class="modal-content">
      <span class="close-btn" id="closeNotificationModal">&times;</span>
      <h2 id="notifTitle">Notification Title</h2>
      <p id="notifMessage">Notification full message here.</p>
      <div class="notifDate" id="notifDate">Date info here</div>
    </div>
  </div>

  <?php include_once "includes/components/navigation.html"; ?>

  <!-- MAIN JS -->
  <script src="public/js/main.js"></script>
  <!-- NOTIF JS -->
  <script src="public/js/utils/notification.js"></script>

</body>
</html>