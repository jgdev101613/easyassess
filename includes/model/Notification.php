<?php
declare(strict_types=1);

class Notification {
  protected PDO $db;

  public function __construct(PDO $db) {
    $this->db = $db;
  }

  public function fetchUserNotifications(string $userId): array {
    $stmt = $this->db->prepare(
      "SELECT id, user_id, title, message, is_read, created_at 
       FROM notifications
       WHERE user_id = :user_id
       ORDER BY created_at DESC"
    );
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateReadStatus(int $notificationId): bool {
    $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");
    return $stmt->execute(['id' => $notificationId]);
  }
}
