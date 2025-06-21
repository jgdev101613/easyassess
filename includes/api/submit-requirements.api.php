<?php
declare(strict_types=1);
session_start();

require_once '../database/dbh.inc.php';
require_once '../controller/ClearanceRequirements.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $studentId = $_SESSION['user']['id'] ?? null;
  $departmentId = $_POST['department_id'] ?? '';
  $attachments = $_FILES['attachments'] ?? [];

  if (!$studentId || !$departmentId || empty($attachments['name'][0])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
  }

  $controller = new ClearanceRequirements($conn, $studentId, $departmentId, $attachments);
  $result = $controller->submit();

  echo json_encode($result);
  exit;
}
