<?php

class EditProfileController {
  private $db;
  private $id;
  private $data;

  public function __construct($db, $id, $data) {
    $this->db = $db;
    $this->id = $id;
    $this->data = $data;
  }

  public function updateProfile() {
    try {
      // Begin transaction
      $this->db->beginTransaction();
  
      // 1. Update email in users table
      $stmtUser = $this->db->prepare("
        UPDATE users 
        SET email = :email 
        WHERE id = :id
      ");
      $stmtUser->execute([
        ':email' => $this->data['email'],
        ':id'    => $this->id,
      ]);
  
      // 2. Get user type
      $stmtType = $this->db->prepare("SELECT user_type FROM users WHERE id = :id");
      $stmtType->execute([':id' => $this->id]);
      $user = $stmtType->fetch(PDO::FETCH_ASSOC);
  
      if (!$user) {
        $this->db->rollBack();
        return ['status' => 'error', 'message' => 'User not found'];
      }
  
      $userType = $user['user_type'];
  
      if ($userType === 'student') {
        // Students table update
        $stmtStudent = $this->db->prepare("
          UPDATE students SET 
            first_name = :first_name,
            middle_name = :middle_name,
            last_name = :last_name,
            course = :course,
            year_level = :year_level,
            section = :section,
            prog_department_id = :department
          WHERE student_id = :id
        ");
        $stmtStudent->execute([
          ':first_name'  => $this->data['first_name'],
          ':middle_name' => $this->data['middle_name'],
          ':last_name'   => $this->data['last_name'],
          ':course'      => $this->data['course'],
          ':year_level'  => $this->data['year_level'],
          ':section'     => $this->data['section'],
          ':department'  => $this->data['department'],
          ':id'          => $this->id
        ]);
  
      } elseif ($userType === 'professor') {
        // Professors table update
        $stmtProf = $this->db->prepare("
          UPDATE professors SET 
            first_name = :first_name,
            middle_name = :middle_name,
            last_name = :last_name,
            department = :department
          WHERE employee_id = :id
        ");
        $stmtProf->execute([
          ':first_name'  => $this->data['first_name'],
          ':middle_name' => $this->data['middle_name'],
          ':last_name'   => $this->data['last_name'],
          ':department'  => $this->data['department'], // department = foreign key
          ':id'          => $this->id
        ]);
  
      } else {
        $this->db->rollBack();
        return ['status' => 'error', 'message' => 'Invalid user type'];
      }
  
      $this->db->commit();
      return ['status' => 'success', 'message' => 'Profile updated successfully!'];
  
    } catch (\Throwable $e) {
      $this->db->rollBack();
      return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
  }
  
}
