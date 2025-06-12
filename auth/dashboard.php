<!-- 
  Copyright © 2025 John Gregg Felicisimo
  All rights reserved. Unauthorized use is prohibited.
-->

<?php
// SESSION
require_once "../includes/session/config.session.inc.php";

// $_SESSION['user'] = [
//   'id' => $fullUser['id'],
//   'profile_photo' => $fullUser['profile_image'] ?? null,
//   'email' => $fullUser['email'] ?? null,
//   'user_type' => $fullUser['user_type'],
//   'status' => $fullUser['status'],
//   'is_logged_in' => true,
// ];

if (!isset($_SESSION['user'])) {
  header('Location: ../index.php');
  exit();
}

$userid = null;
$first_name = null;
$name_in_initial = null;
$profile_photo = null;

// if ($_SESSION['user']['user_type'] === 'Student') {
//   header('Location: attendance.php');
//   exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../public/css/main.css" />
    <link rel="stylesheet" href="../public/css/loading.css" />
    <link rel="stylesheet" href="../public/css/dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- ICON -->
    <link rel="icon" type="image/png" href="../assets/saclilogo.png">

    <!-- TOASTIFY -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <title>Easy Assess - Dashboard</title>
</head>
<body>
  <header>
    <img src="../assets/saclilogo.png" height="32" alt="">
    SACLI - Easy Assess
  </header>

  <div class="container">
    <div class="clearance-box">
      <div class="clearance-title">Librarian</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle completed"></span>
        <p>Signed</p>
      </div>
    </div>

    <div class="clearance-box">
      <div class="clearance-title">Office of Student Affairs</div>
      <div class="sub-items">- POD</div>
      <div class="sub-items">- Psychology Test</div>
      <div class="sub-items">- Foundation</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box">
      <div class="clearance-title">Dean</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box">
      <div class="clearance-title">Registrar</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>

    <div class="clearance-box">
      <div class="clearance-title">Accounting</div>
      <div class="sub-items">View requirements & request signature</div>
      <div class="status">
        <span class="status-circle pending"></span>
        <p>Pending</p>
      </div>
    </div>
  </div>

  <nav>
    <a href="#" class="nav-link active">
      <!-- <i class="fa-solid fa-signature"></i> -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
      </svg>
      Clearance
      <span class="active-indicator"></span>
    </a>
    <a href="#" class="nav-link">
      <!-- <i class="fas fa-user"></i> -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
      </svg>
      Profile
      <span class="active-indicator"></span>
    </a>
    <a href="#" class="nav-link">
      <!-- <i class="fas fa-bell"></i> -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
      </svg>
      Notification
      
      <span class="active-indicator"></span>
    </a>
    <a href="#" class="nav-link">
      <!-- <i class="fas fa-cog"></i> -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
      </svg>
      Settings
      <span class="active-indicator"></span>
    </a>
  </nav>
    
</body>
</html>