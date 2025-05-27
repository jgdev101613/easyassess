<?php 

declare(strict_types=1);

class SignInController extends SignIn {
  private $studentID;
  private $studentRePassword;

  public function __construct($db, $studentID, $studentPassword) {
    parent::__construct($db);
    $this->studentID = $studentID;
    $this->studentPassword = $studentPassword;
  }

  public function signInUser() {
    if ($this->emptyInput() !== null) {
      return $this->emptyInput();
    } else {

    $response = $this->getUser(
      $this->studentID, 
      $this->studentPassword, 
    );
      return $response;
    }
  }

  private function emptyInput() {
    $result = null;

    if (empty($this->studentID) || empty($this->studentPassword)) {
      $message = 'Fields Cannot Be Empty!';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

}