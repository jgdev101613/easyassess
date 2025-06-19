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
        return ['status' => 'error', 'message' => 'User not found'];
      }

      $userType = $user['user_type'];
      $table = ($userType === 'student') ? 'students' : (($userType === 'professor') ? 'professors' : null);

      if (!$table) {
        return ['status' => 'error', 'message' => 'Invalid user type'];
      }

      // 3. Update student or professor table
      $stmtProfile = $this->db->prepare("
        UPDATE $table SET 
          first_name = :first_name,
          middle_name = :middle_name,
          last_name = :last_name,
          course = :course,
          year = :year,
          section = :section,
          department = :department
        WHERE student_id = :id OR user_id = :id
      ");

      $stmtProfile->execute([
        ':first_name'  => $this->data['first_name'],
        ':middle_name' => $this->data['middle_name'],
        ':last_name'   => $this->data['last_name'],
        ':course'      => $this->data['course'],
        ':year'        => $this->data['year'],
        ':section'     => $this->data['section'],
        ':department'  => $this->data['department'],
        ':id'          => $this->id
      ]);

      $this->db->commit();
      return ['status' => 'success', 'message' => 'Profile updated successfully!'];

    } catch (\Throwable $e) {
      $this->db->rollBack();
      return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
  }
}
