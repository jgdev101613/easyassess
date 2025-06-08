<?php 

declare(strict_types=1);

require_once 'signin.classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signinStudentId'])) {
  
  // Grabbing data from the form
  $studentID = $_POST["signinStudentId"];
  $studentPassword = $_POST["signinStudentPassword"];

  // Initialize your database connection
  $db = $conn; 

  // Instantiate signin controller
  include_once "../database/dbh.inc.php";
  include_once "signin-contr.classes.php";
  $signin = new SignInController($db, $studentID, $studentPassword);
  $response = $signin->signInUser();

  // Running Error handling
  if ($response['status'] === 'success') {
    //accountActivatedEmail($accountType, $accountEmail);
    
    $message = 'Login Successful!';
    $response = ['status' => 'success', 'message' => $message, 'session' => $_SESSION];
  } else {
    $message = $response['message'];
    $response = ['status' => 'error', 'message' => $message];
  }

  // Going back to frontpage
  echo json_encode($response);
  exit();
}