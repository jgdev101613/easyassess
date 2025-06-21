<?php
declare(strict_types=1);
header("Content-Type: application/json"); 

require_once '../session/config.session.inc.php';

if (!isset($_SESSION['user']['id'])) {
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

require_once '../database/dbh.inc.php';
require_once '../controller/NotificationController.php';

$userId = $_SESSION['user']['id'];

$notifController = new NotificationController($conn, $userId);
echo json_encode($notifController->getNotifications());
exit;
