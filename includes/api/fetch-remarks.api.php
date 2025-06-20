<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  require_once '../database/dbh.inc.php';
  require_once '../model/Clearance.php';


  $input = json_decode(file_get_contents("php://input"), true);
  $userId = $_SESSION['user']['id'] ?? "2301000555";
  $department = $input['department'] ?? '';

  $userId = str_replace('-', '', $userId);

  if (!$userId || !$department) {
    echo json_encode(['error' => 'Invalid request.']);
    exit;
  }

  $remarksModel = new Clearance($conn);
  $remarks = $remarksModel->getRemarks($userId, $department);

  echo json_encode(['remarks' => $remarks]);
  exit;
}
