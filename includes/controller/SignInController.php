<?php 

declare(strict_types=1);

require_once "../model/User.php";

class SignInController extends User {
  private $userId;
  private $password;

  public function __construct($db, $userId, $password) {
    parent::__construct($db);
    $this->userId = $userId;
    $this->password = $password;
  }

  public function signInUser() {
    if ($this->emptyInput() !== null) {
      return $this->emptyInput();
    } else {

    $response = $this->getUser(
      $this->userId, 
      $this->password, 
    );
      return $response;
    }
  }

  private function emptyInput() {
    $result = null;

    if (empty($this->userId) || empty($this->password)) {
      $message = 'Fields Cannot Be Empty!';
      $result = ['status' => 'error', 'message' => $message];
    } 

    return $result;
  }

}