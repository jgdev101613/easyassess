<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  require_once '../database/dbh.inc.php';
  require_once '../model/Clearance.php';

  $userId = $_SESSION['user']['id'] ?? null;

  if (!$userId) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
  }

  $model = new Clearance($conn);
  $statuses = $model->getClearanceStatuses($userId);

  echo json_encode($statuses);
  exit;
}
