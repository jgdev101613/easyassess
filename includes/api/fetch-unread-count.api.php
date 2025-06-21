<?php
declare(strict_types=1);
require_once '../session/config.session.inc.php';
require_once '../database/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
  }

  $stmt = $conn->prepare("SELECT COUNT(*) as unread FROM notifications WHERE user_id = :uid AND is_read = 0");
  $stmt->execute([':uid' => $_SESSION['user']['id']]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode(['unread' => (int)$result['unread']]);
  exit;
}
