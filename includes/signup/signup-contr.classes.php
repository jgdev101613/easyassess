<?php 

declare(strict_types=1);

class SignUpController extends SignUp {
  private $studentID;
  private $studentFirstName;
  private $studentMiddleName;
  private $studentLastName;
  private $studentEmail;
  private $studentPassword;
  private $studentRePassword;

  public function __construct($db, $studentID, $studentFirstName, $studentMiddleName, $studentLastName, $studentEmail, $studentPassword, $studentRePassword) {
    parent::__construct($db);
    $this->studentID = $studentID;
    $this->studentFirstName = $studentFirstName;
    $this->studentMiddleName = $studentMiddleName;
    $this->studentLastName = $studentLastName;
    $this->studentEmail = $studentEmail;
    $this->studentPassword = $studentPassword;
    $this->studentRePassword = $studentRePassword;
  }

  public function signupUser() {
    if ($this->emptyInput() !== null) {
      return $this->emptyInput();
    } elseif ($this->invalidStudentID() !== null) {
      return $this->invalidStudentID();
    } elseif ($this->invalidEmail() !== null) {
      return $this->invalidEmail();
    } elseif ($this->passwordMatch() !== null) {
      return $this->passwordMatch();
    } elseif ($this->studentIdTaken() !== null) {
      return $this->studentIdTaken();
    } else {

    $response = $this->createUser(
        $this->studentID, 
        $this->studentFirstName, 
        $this->studentMiddleName, 
        $this->studentLastName, 
        $this->studentEmail, 
        $this->studentPassword, 
        $this->studentRePassword
      );

      return $response;
    }
  }

  private function emptyInput() {
    $result = null;

    if (empty($this->studentID) || empty($this->studentFirstName) || empty($this->studentLastName) || empty($this->studentEmail) || empty($this->studentPassword) || empty($this->studentRePassword)) {
      $message = '<div>Fields Cannot Be Empty!</div>';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function invalidStudentID() {
    $result = null;

    if (!preg_match('/^[0-9-]+$/', $this->studentID)) {
      $message = '<div>Invalid Student ID!</div>';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function invalidEmail() {
    $result = null;

    if (!filter_var($this->studentEmail, FILTER_VALIDATE_EMAIL)) {
      $message = '<div>Invalid Email!</div>';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function passwordMatch() {
    $result = null;

    if ($this->studentPassword !== $this->studentRePassword) {
      $message = '<div>Passwords Do Not Match!</div>';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function studentIdTaken() {
    $result = null;

    if($this->checkUser($this->studentID, $this->studentEmail)) {
        $message = '<div>Student ID or Email already exists!</div>';
        $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

}