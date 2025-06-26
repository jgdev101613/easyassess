<?php
declare(strict_types=1);
require_once '../session/config.session.inc.php';
require_once '../database/dbh.inc.php';
require_once '../controller/ClearanceController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $studentId = $_SESSION['user']['id'] ?? null;
  $departmentId = $_POST['department_id'] ?? '';
  $attachments = $_FILES['attachments'] ?? [];

  if (!$studentId || !$departmentId) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
  }
  
  if (empty($attachments['name'][0])) {
    // Allow no attachments but still save status as pending
    $attachments = []; // explicitly make it empty
  }

  $controller = new ClearanceController($conn, $studentId, $departmentId, $attachments);
  $result = $controller->submit();

  echo json_encode($result);
  exit;
}
