<?php
class Clearance {
  private PDO $db;

  public function __construct(PDO $db) {
    $this->db = $db;
  }

  public function getRemarks($student_id, string $department): string {
    $sql = "SELECT remarks FROM clearance_status WHERE student_id = :student_id AND department_id = :department LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    $stmt->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['remarks'] ?? "No remarks yet.";
  }

  public function getClearanceStatuses($student_id): array {
    // Departments in order
    $departments = ['LIB2025', 'OSA2025', 'DEAN2025', 'REG2025', 'ACC2025'];

    $results = [];
    foreach ($departments as $deptId) {
      $stmt = $this->db->prepare("SELECT status FROM clearance_status WHERE student_id = :student_id AND department_id = :did");
      $stmt->execute([
        ':student_id' => $student_id,
        ':did' => $deptId
      ]);

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $results[] = [
        'department_id' => $deptId,
        'status' => $row['status'] ?? null
      ];
    }

    return $results;
  }

  public function saveRequirement($studentId, string $departmentId, array $filePaths): array {
    try {
      $stmt = $this->db->prepare(
        "INSERT INTO clearance_requirements (student_id, department_id, attachment) 
         VALUES (:student_id, :department_id, :attachment)"
      );

      $isThereStatus = $this->getRemarks($studentId, $departmentId);

      if ($isThereStatus === "No remarks yet.") {
        $insertStatusStmt = $this->db->prepare(
          "INSERT INTO clearance_status (student_id, department_id, status)
          VALUES (:student_id, :department_id, :status)"
        );

        $insertStatusStmt->execute([
          ':student_id' => $studentId,
          ':department_id' => $departmentId,
          ':status' => "pending"
        ]);
      }

      $attachments = implode(',', $filePaths);
      if (empty($attachments)) {
        $attachments = 'No Attachment'; // or use 'no_attachment' if you prefer
      }

      $stmt->execute([
        ':student_id' => $studentId,
        ':department_id' => $departmentId,
        ':attachment' => $attachments
      ]);

      // Update the clearance status to "pending"
      $clearanceStatus = $this->updateClearanceStatus($studentId, $departmentId);
      if (!$clearanceStatus) {
        return ['success' => false, 'message' => $clearanceStatus['message']];
      }

      return ['success' => true];
    } catch (Exception $e) {
      return ['success' => false, 'message' => $e->getMessage()];
    }
  }

  public function updateClearanceStatus(string $studentId, string $departmentId) {
    try {
      $stmt = $this->db->prepare(
        "UPDATE clearance_status 
         SET status = 'pending' 
         WHERE student_id = :student_id AND department_id = :department_id"
      );
      $stmt->execute([
        ':student_id' => $studentId,
        ':department_id' => $departmentId
      ]);
      return ['success' => true];
    } catch (\Throwable $th) {
      return ['success' => false, 'message' => $th->getMessage()];
    }
    
  }

  public function fetchClearanceByDepartment($department_id) {
    // Step 1: Get clearance statuses
    $stmt = $this->db->prepare("
      SELECT cs.student_id, cs.status, cs.updated_at,
             s.first_name, s.middle_name, s.last_name, s.course, s.year_level, s.section
      FROM clearance_status cs
      JOIN students s ON cs.student_id = s.student_id
      WHERE cs.department_id = ?
      ORDER BY cs.updated_at DESC
    ");
    $stmt->execute([$department_id]);
    $clearances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Step 2: For each clearance, fetch their attachments
    foreach ($clearances as &$clr) {
      $clr['full_name'] = $clr['first_name'] . ' ' . $clr['middle_name'] . ' ' . $clr['last_name'];
    
      $attachmentsStmt = $this->db->prepare("
        SELECT attachment FROM clearance_requirements
        WHERE student_id = ? AND department_id = ?
      ");
      $attachmentsStmt->execute([$clr['student_id'], $department_id]);
      $attachmentsRaw = $attachmentsStmt->fetchAll(PDO::FETCH_ASSOC);
    
      $clr['attachments'] = [];
    
      foreach ($attachmentsRaw as $row) {
        $files = explode(',', $row['attachment']); // split by comma
        foreach ($files as $file) {
          $trimmed = trim($file);
          if ($trimmed !== '') {
            $clr['attachments'][] = ['attachment' => $trimmed];
          }
        }
      }
    }

    return $clearances;
  }

}
