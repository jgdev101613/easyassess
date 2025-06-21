<?php
declare(strict_types=1);

require_once '../database/dbh.inc.php';
require_once '../controller/NotificationController.php';
require_once '../session/config.session.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($_SESSION['user']['id']) || !isset($data['notificationId'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid access']);
    exit;
  }

  $controller = new NotificationController($conn, $_SESSION['user']['id']);
  $success = $controller->markAsRead((int)$data['notificationId']);

  echo json_encode(['success' => $success]);
  exit;
}
