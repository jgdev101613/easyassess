<?php 

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signinUserId'])) {
  
  // Grabbing data from the form
  $signinUserId = $_POST["signinUserId"];
  $signinPassword = $_POST["signinPassword"];

  // Instantiate signin controller
  include_once "../database/dbh.inc.php";
  include_once "../controller/SignInController.php";
  
  // Initialize your database connection
  $db = $conn; 
  $signin = new SignInController($db, $signinUserId, $signinPassword);
  $response = $signin->signInUser();

  // Running Error handling
  if ($response['status'] === 'success') {
    //accountActivatedEmail($accountType, $accountEmail);
    
    $message = 'Login Successful!';
    $response = ['status' => 'success', 'message' => $message];
  } else {
    $message = $response['message'];
    $response = ['status' => 'error', 'message' => $message];
  }

  // Going back to frontpage
  echo json_encode($response);
  exit();
}