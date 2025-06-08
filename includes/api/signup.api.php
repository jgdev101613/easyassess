<?php 

declare(strict_types=1);

require_once 'signup.classes.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerStudentID'])) {
  
  // User Auth
  $userId = $_POST["registerStudentID"];
  $email = $_POST["regsterStudentEmail"];
  $password = $_POST["registerStudentPassword"];
  $repassword = $_POST["registerStudentRePassword"];

  // User Details
  $studentFirstName = $_POST["registerStudentFirstName"];
  $studentMiddleName = $_POST["registerStudentMiddleName"];
  $studentLastName = $_POST["registerStudentLastName"];

  // Initialize your database connection
  $db = $conn; 

  // Instantiate signup controller
  include_once "../database/dbh.inc.php";
  include_once "../controller/SignUpController.php";
  $signup = new SignUpController($db, $userId, $user_type, $email, $password, $repassword, $profile_image);
  $response = $signup->signupUser();

  // Running Error handling
  if ($response['status'] === 'success') {
    //accountActivatedEmail($accountType, $accountEmail);
    
    $message = 'Registered Successfully! Please check your email for activation link.';
    $response = ['status' => 'success', 'message' => $message];
  } else {
    $message = $response['message'];
    $response = ['status' => 'error', 'message' => $message];
  }

  // Going back to frontpage
  echo json_encode($response);
  exit();
}