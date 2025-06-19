<?php
// SESSION
require_once "includes/session/config.session.inc.php";


if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit();
}

$user_type = $_SESSION['user']['user_type'];
$userid = $_SESSION['user']['id'];
$profile_photo = $_SESSION['user']['profile_image'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="public/css/main.css" />
    <link rel="stylesheet" href="public/css/loading.css" />
    <link rel="stylesheet" href="public/css/component.css" />
    <link rel="stylesheet" href="public/css/dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- ICON -->
    <link rel="icon" type="image/png" href="assets/saclilogo.png">

    <!-- TOASTIFY -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <title>Easy Assess - Dashboard</title>
</head>
<body>

  <?php
  // Header
  include_once "includes/components/header.html";

  // 
  if ($user_type === "student") {
    include_once "auth/students.php";
  } 
  
  if ($user_type === "Admin") {
    echo "Admin";
  }
  // Navigation
  include_once "includes/components/navigation.html";
  ?>

  <script src="public/js/main.js "></script>
    
</body>
</html>