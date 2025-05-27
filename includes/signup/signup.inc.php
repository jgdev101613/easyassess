<?php 

declare(strict_types=1);

require_once 'signup.classes.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerStudentID'])) {
  
  // Grabbing data from the form
  $studentID = $_POST["registerStudentID"];
  $studentFirstName = $_POST["registerStudentFirstName"];
  $studentMiddleName = $_POST["registerStudentMiddleName"];
  $studentLastName = $_POST["registerStudentLastName"];
  $studentEmail = $_POST["regsterStudentEmail"];
  $studentPassword = $_POST["registerStudentPassword"];
  $studentRePassword = $_POST["registerStudentRePassword"];

  // Initialize your database connection
  $db = $conn; 

  // Instantiate signup controller
  include_once "../database/dbh.inc.php";
  include_once "signup-contr.classes.php";
  $signup = new SignUpController($db, $studentID, $studentFirstName, $studentMiddleName, $studentLastName, $studentEmail, $studentPassword, $studentRePassword);
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