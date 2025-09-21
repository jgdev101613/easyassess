<?php 

declare(strict_types=1);

require_once "../model/User.php";

class SignUpController extends User {
  private $userId;
  private $user_type;
  private $email;
  private $password;
  private $repassword;
  private $profile_image;
  private $firstName;
  private $middleName;
  private $lastName;
  private $eRole;

  public function __construct($db, $userId, $user_type, $email, $password, $repassword, $profile_image, $firstName, $middleName, $lastName, $eRole) {
    parent::__construct($db);
    $this->userId = $userId;
    $this->user_type = $user_type;
    $this->email = $email;
    $this->password = $password;
    $this->repassword = $repassword;
    $this->profile_image = $profile_image;
    $this->firstName = $firstName;
    $this->middleName = $middleName;
    $this->lastName = $lastName;
    $this->eRole = $eRole;
  }

  public function signupUser() {
    if ($this->invalidUserId() !== null) {
      return $this->invalidUserId();
    } elseif ($this->invalidEmail() !== null) {
      return $this->invalidEmail();
    } elseif ($this->passwordMatch() !== null) {
      return $this->passwordMatch();
    } elseif ($this->userIdTaken() !== null) {
      return $this->userIdTaken();
    } else {

    $response = $this->createUser(
        $this->userId, 
        $this->user_type,
        $this->email,
        $this->password,
        $this->profile_image,
        $this->firstName,
        $this->middleName,
        $this->lastName,
        $this->eRole
      );

      return $response;
    }
  }

  /*
  private function emptyInput() {
    $result = null;

    if (empty($this->studentID) || empty($this->studentFirstName) || empty($this->studentLastName) || empty($this->studentEmail) || empty($this->studentPassword) || empty($this->studentRePassword)) {
      $message = '<div>Fields Cannot Be Empty!</div>';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }
  */

  private function invalidUserId() {
    $result = null;

    if (!preg_match('/^[0-9-]+$/', $this->userId)) {
      $message = 'Invalid Student ID!';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function invalidEmail() {
    $result = null;

    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $message = 'Invalid Email!';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

  private function passwordMatch() {
    $result = null;

    if ($this->password !== $this->repassword) {
      $message = 'Passwords Do Not Match!';
      $result = ['status' => 'error', 'message' => $message];
    } 
    
    // ✅ Check password length
    $length = strlen($this->password);
    if ($length < 8 || $length > 16) {
      $message = 'Password must be between 8 and 16 characters!';
      return ['status' => 'error', 'message' => $message];
    }

    return $result;
  }

  private function userIdTaken() {
    try {
      $duplicates = $this->checkDuplicateDetails($this->userId, $this->email);
  
      if (isset($duplicates['status']) && $duplicates['status'] === 'error') {
        return $duplicates; // return the error directly
      }
  
      if ($duplicates['id'] && $duplicates['email']) {
        $message = 'Both Student ID and Email already exist!';
      } elseif ($duplicates['id']) {
        $message = 'Student ID already exists!';
      } elseif ($duplicates['email']) {
        $message = 'Email already exists!';
      } else {
        return null; // no duplicates
      }
  
      return ['status' => 'error', 'message' => $message];
  
    } catch (\Throwable $th) {
      return ['status' => 'error', 'message' => 'Check failed: ' . $th->getMessage()];
    }
  }

}