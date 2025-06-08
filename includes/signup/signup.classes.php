<?php 

declare(strict_types=1);

require_once("../database/constant.php");
require_once("../database/dbh.inc.php");

class SignUp {
  private $db;
    
  // Constructor to initialize the database connection
  public function __construct($db) {
      $this->db = $db;
  }

  public function createUser($userId, $email, $password) {
    try {
      $options = [
        'cost' => 12,
      ];

      $stmt = $this->db->prepare('
        INSERT INTO users (id, email, passowrd) 
        VALUES (:id, :email, :password);
      ');

      $stmt->execute([
        'id' => $userId,
        'email' => $email,
        'studentPassword' => password_hash($password, PASSWORD_BCRYPT, $options), // More Secured Hashing
      ]);

      $stmt = null; // Close the statement
      return ['status' => 'success', 'message' => 'Account Created Successfully!'];
    } catch (PDOException $th) {
      $message = 'Database error: ' . $th->getMessage();
      return ['status' => 'error', 'message' => $message];
    }

  }

  public function checkDuplicate($userId, $email) {
    $result;
    try {
      $stmt = $this->db->prepare('SELECT id FROM students WHERE id = :id OR email = :email;');
      $stmt->execute([
        'id' => $userId,
        'email' => $email
      ]);

      if ($stmt->rowCount() > 0) {
        $result = true;
      } else {
        $result = false;
      }

      $stmt = null; // Close the statement
      return $result;

    } catch (PDOException $e) {
      $message = 'Database error: ' . $e->getMessage();
      return ['status' => 'error', 'message' => $message];
    }
  }
}