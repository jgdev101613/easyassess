<?php
// Copyright © 2025 John Gregg Felicisimo
// All rights reserved. Unauthorized use is prohibited.

require_once '../database/dbh.inc.php';

class User {
  private $db;

  public function __construct($db) {
      $this->db = $db;
  }

  public function checkDuplicate($userId, $email) {
    $result;
    try {
      $stmt = $this->db->prepare('SELECT id FROM users WHERE id = :id OR email = :email;');
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

  public function createUser(
      $userId, 
      $user_type,
      $email,
      $password,
      $profile_image
    ) {
    try {
      $options = [
        'cost' => 12,
      ];

      $userId = str_replace('-', '', $userId);

      $stmt = $this->db->prepare('
        INSERT INTO users (id, user_type, email, password, profile_image, status) 
        VALUES (:id, :user_type, :email, :password, :profile_image, :status);
      ');

      $stmt->execute([
        'id' => $userId,
        'user_type' => $user_type,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT, $options),
        'profile_image' => $profile_image,
        'status' => "Pending"
      ]);

      $stmt = null; // Close the statement
      return ['status' => 'success', 'message' => 'Account Created Successfully!'];
    } catch (PDOException $th) {
      $message = 'Database error: ' . $th->getMessage();
      return ['status' => 'error', 'message' => $message];
    }

  }

  public function getUser($userId, $password) {
    try {
      $stmt = $this->db->prepare('
        SELECT password FROM users WHERE id = :id;
      ');

      $userId = str_replace('-', '', $userId);

      $stmt->execute([
        'id' => $userId,
      ]);

      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $row['password'])) {
          // Set the account details in the session
          $this->getAccountDetails($userId);

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


  function getAccountDetails($userId) {
    try {
      // Step 1: Get user base info
      $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
      $stmt->execute([':id' => $userId]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) return false; // User not found

      // Step 2: Merge extra data from student or professor
      if ($user['user_type'] === 'student') {
          $stmt = $this->db->prepare('SELECT * FROM students WHERE user_id = :id');
          $stmt->execute([':id' => $userId]);
          $extra = $stmt->fetch(PDO::FETCH_ASSOC);
      } elseif ($user['user_type'] === 'professor') {
          $stmt = $this->db->prepare('SELECT * FROM professors WHERE user_id = :id');
          $stmt->execute([':id' => $userId]);
          $extra = $stmt->fetch(PDO::FETCH_ASSOC);
      } else {
          $extra = [];
      }

      $fullUser = array_merge($user, $extra);

      // Step 3: Start session and set values
      require_once "../session/config.session.inc.php";
      regenerate_session_id();

      $_SESSION['user'] = [
          'id' => $fullUser['id'],
          'profile_photo' => $fullUser['profile_image'] ?? null,
          'email' => $fullUser['email'] ?? null,
          'user_type' => $fullUser['user_type'],
          'is_logged_in' => true,
      ];

      $stmt = null; // Close the statement
      return $fullUser;
    } catch (\Throwable $th) {
      $message = 'Database error: ' . $th->getMessage();
      return ['status' => 'error', 'message' => $message];
    }
  }

}