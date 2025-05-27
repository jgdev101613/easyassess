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

  public function createUser($studentId, $studentFirstName, $studentMiddelName, $studentLastName, $studentEmail, $studentPassword, $studentRePassword) {
    try {
      // Concatenate and capitalize the full name
      $fullName = ucwords(strtolower(trim($studentFirstName . ' ' . $studentMiddelName . ' ' . $studentLastName)));
      $options = [
        'cost' => 12,
      ];

      $stmt = $this->db->prepare('
        INSERT INTO students (student_id, student_name, student_password, student_email) 
        VALUES (:studentId, :studentName, :studentPassword, :studentEmail);
      ');

      $stmt->execute([
        'studentId' => $studentId,
        'studentName' => $fullName,
        'studentEmail' => $studentEmail,
        'studentPassword' => password_hash($studentPassword, PASSWORD_BCRYPT, $options), // More Secured Hashing
      ]);

      $stmt = null; // Close the statement
      return ['status' => 'success', 'message' => 'Account Created Successfully!'];
    } catch (PDOException $th) {
      $message = '<div>Database error: ' . $th->getMessage() . '</div>';
      return ['status' => 'error', 'message' => $message];
    }

  }

  public function checkUser($studentId, $studentEmail) {
    $result;
    try {
      $stmt = $this->db->prepare('SELECT student_id FROM students WHERE student_id = :studentId OR student_email = :studentEmail;');
      $stmt->execute([
        'studentId' => $studentId,
        'studentEmail' => $studentEmail
      ]);

      if ($stmt->rowCount() > 0) {
        $result = true;
      } else {
        $result = false;
      }

      $stmt = null; // Close the statement
      return $result;

    } catch (PDOException $e) {
      $message = '<div>Database error: ' . $e->getMessage() . '</div>';
      return ['status' => 'error', 'message' => $message];
    }
  }
}