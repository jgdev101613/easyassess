<?php
require_once '../../database/dbh.inc.php'; // your DB connection
require_once '../../session/config.session.inc.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request method']);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$studentId = $data['student_id'] ?? null;
$departmentId = $_SESSION['user']['department_id'] ?? null;

if (!$studentId) {
  echo json_encode(['success' => false, 'message' => 'Missing student ID']);
  exit;
}

try {
  $stmt = $conn->prepare("UPDATE clearance_status SET status = 'approved', updated_at = NOW() WHERE student_id = ? AND department_id = ?");
  $stmt->execute([$studentId, $departmentId]);

  if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true, 'message' => 'Clearance approved']);
  } else {
    echo json_encode(['success' => false, 'message' => 'No rows updated.']);
  }
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
