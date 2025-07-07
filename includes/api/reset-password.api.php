<?php 

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
  
  // Grabbing data from the form
  $userId = $_POST["userId"];
  $currentPassword = $_POST["currentPassword"];
  $newPassword = $_POST["newPassword"];
  $confirmPassword = $_POST["confirmPassword"];

  include_once "../model/User.php";
  include_once "../database/dbh.inc.php";

  $user = new User($conn);
  $response = $user->resetPassword($userId, $currentPassword, $newPassword, $confirmPassword);

  echo json_encode($response);
  exit();
}