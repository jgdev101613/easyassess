<?php
declare(strict_types=1);

require_once '../model/Notification.php';

class NotificationController extends Notification {
  private string $userId;

  public function __construct(PDO $db, string $userId) {
    parent::__construct($db);
    $this->userId = $userId;
  }

  public function getNotifications(): array {
    return $this->fetchUserNotifications($this->userId);
  }

  public function markAsRead(int $notificationId): bool {
    return $this->updateReadStatus($notificationId);
  }
}
