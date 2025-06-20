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
}
