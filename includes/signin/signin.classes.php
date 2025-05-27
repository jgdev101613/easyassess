<?php 

declare(strict_types=1);

require_once("../database/constant.php");
require_once("../database/dbh.inc.php");
require_once("./signin-getDetails.php");

class SignIn {
  private $db;
    
  // Constructor to initialize the database connection
  public function __construct($db) {
      $this->db = $db;
  }

  public function getUser($studentId, $studentPassword) {
    try {
      $options = [
        'cost' => 12,
      ];

      $stmt = $this->db->prepare('
        SELECT student_password FROM students WHERE student_id = :studentId;
      ');

      $stmt->execute([
        'studentId' => $studentId,
      ]);

      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (password_verify($studentPassword, $row[0]['student_password'])) {
          // Set the account details in the session
          getAccountDetails($studentId);

          return ['status' => 'success', 'message' => 'Login Successful!'];
        } else {
          return ['status' => 'error', 'message' => 'Invalid Password!'];
        }
      } else {
        return ['status' => 'error', 'message' => 'User Not Found!'];

      }

      $stmt = null; // Close the statement
      return ['status' => 'success', 'message' => 'Account Created Successfully!'];
    } catch (PDOException $th) {
      $message = '<div>Database error: ' . $th->getMessage() . '</div>';
      return ['status' => 'error', 'message' => $message];
    }

  }
}