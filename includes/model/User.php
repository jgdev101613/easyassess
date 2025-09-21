<?php
// Copyright © 2025 John Gregg Felicisimo
// All rights reserved. Unauthorized use is prohibited.

require_once '../database/dbh.inc.php';

class User {
  private $db;

  public function __construct($db) {
      $this->db = $db;
  }

  public function checkDuplicateDetails($userId, $email) {
    try {
      $stmt = $this->db->prepare('SELECT id, email FROM users WHERE id = :id OR email = :email');
      $stmt->execute([
        'id' => str_replace('-', '', $userId),
        'email' => $email
      ]);
  
      $result = ['id' => false, 'email' => false];
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['id'] === str_replace('-', '', $userId)) {
          $result['id'] = true;
        }
        if ($row['email'] === $email) {
          $result['email'] = true;
        }
      }
  
      return $result;
    } catch (PDOException $e) {
      return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
  }

  public function checkDuplicateUserId($user_id) {
    try {
      $stmt = $this->db->prepare('SELECT user_id FROM students WHERE user_id = :user_id');
      $stmt->execute([
        'user_id' => $user_id,
      ]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
  }

  public function generateUniqueUserId() {
    do {
      $prefix = date("Ym");
      $random = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
      $userId = $prefix . $random;
  
      $isDuplicate = $this->checkDuplicateUserId($userId);
    } while ($isDuplicate === true);
  
    return $userId;
  }

  public function createUser(
      $userId, 
      $user_type,
      $email,
      $password,
      $profile_image,
      $firstName,
      $middleName,
      $lastName,
      $eRole
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

      $sucess = $stmt->execute([
        'id' => $userId,
        'user_type' => $user_type,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT, $options),
        'profile_image' => $profile_image,
        'status' => "Active"
      ]);

      if ($sucess) {
        try {
          // ✅ Query executed successfully
          if ($user_type === "student") {
            $user_id = $this->generateUniqueUserId();

            $studentsStmt = $this->db->prepare('
              INSERT INTO students (user_id, student_id, first_name, middle_name, last_name) 
              VALUES (:user_id, :student_id, :first_name, :middle_name, :last_name);
            ');

            $user_id = $this->generateUniqueUserId();

            $studentsStmt->execute([
              'user_id' => $user_id,
              'student_id' => $userId,
              'first_name' => $firstName,
              'middle_name' => $middleName,
              'last_name' => $lastName,
            ]);
          } else {
            $user_id = $this->generateUniqueUserId();

            $studentsStmt = $this->db->prepare('
              INSERT INTO professors (user_id, employee_id, first_name, middle_name, last_name, department, position) 
              VALUES (:user_id, :employee_id, :first_name, :middle_name, :last_name, :department, :position);
            ');

            $user_id = $this->generateUniqueUserId();

            $studentsStmt->execute([
              'user_id' => $user_id,
              'employee_id' => $userId,
              'first_name' => $firstName,
              'middle_name' => $middleName,
              'last_name' => $lastName,
              'department' => $eRole,
              'position' => "Employee",
            ]);
          }
          

          return ['status' => 'success', 'message' => 'Account Created Successfully!'];
        } catch (\Throwable $th) {
          $message = 'Database error: ' . $th->getMessage();
          return ['status' => 'error', 'message' => $message];
        }
      }
    } catch (PDOException $th) {
      $message = 'Database error: ' . $th->getMessage();
      return ['status' => 'error', 'message' => $message];
    }

  }

  public function resetPassword($userId, $currentPassword, $newPassword, $confirmPassword) {
    if ($newPassword !== $confirmPassword) {
      return ['status' => 'error', 'message' => 'Password do not match'];
    }

    $options = [
      'cost' => 12,
    ];

    $stmt = $this->db->prepare('
      SELECT password FROM users WHERE id = :id;
    ');

    $stmt->execute([
      'id' => $userId,    
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($currentPassword, $row['password'])) {
      $stmt = $this->db->prepare('
        UPDATE users SET password = :password WHERE id = :id;   
      ');

      $stmt->execute([
        'password' => password_hash($newPassword, PASSWORD_BCRYPT, $options),
        'id' => $userId,
      ]);     

      return ['status' => 'success', 'message' => 'Password Updated Successfully!'];
    } else {
      return ['status' => 'error', 'message' => 'Invalid Current Password!'];
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
          $wow = $this->getAccountDetails($userId);

          $stmt = $this->db->prepare('
            SELECT status FROM users WHERE id = :id;
          ');

          $stmt->execute([
            'id' => $userId,
          ]);

          $statusRow = $stmt->fetch(PDO::FETCH_ASSOC);
          $status = $statusRow['status'];

          if ($status === 'Pending' || $status === "Blocked") {
            return ['status' => 'warning', 'message' => 'Your account is not yet activated. Please contact your administrator'];
          }

          return ['status' => 'success', 'message' => 'User Found'];
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
          $stmt = $this->db->prepare('SELECT * FROM students WHERE student_id = :id');
          $stmt->execute([':id' => $userId]);
          $extra = $stmt->fetch(PDO::FETCH_ASSOC);
      } elseif ($user['user_type'] === 'professor') {
          $stmt = $this->db->prepare('SELECT p.*, d.name AS department_name
            FROM professors p
            JOIN departments d ON p.department = d.id
            WHERE p.employee_id = :id
          ');
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
          'user_type' => $fullUser['user_type'],
          'email' => $fullUser['email'],
          'profile_image' => $fullUser['profile_image'] ?? null,
          'department_id' => $fullUser['department'] ?? null,
          'department_name' => $fullUser['department_name'] ?? null,
          'created_at' => $fullUser['created_at'],
          'status' => $fullUser['status'],
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