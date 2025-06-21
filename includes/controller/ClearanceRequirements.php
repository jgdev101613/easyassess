<?php
declare(strict_types=1);

require_once '../model/Clearance.php';

class ClearanceRequirements extends Clearance {
  private string $studentId;
  private string $departmentId;
  private array $files;

  public function __construct($db, $studentId, string $departmentId, array $files) {
    parent::__construct($db);
    $this->studentId = $studentId;
    $this->departmentId = $departmentId;
    $this->files = $files;
  }

  public function submit(): array {
    if ($this->hasEmptyFields()) {
      return ['success' => false, 'message' => 'Required fields missing.'];
    }

    $storedPaths = $this->storeAttachments($this->files, $this->studentId);
    if (empty($storedPaths)) {
      return ['success' => false, 'message' => 'No files were uploaded.'];
    }

    return $this->saveRequirement($this->studentId, $this->departmentId, $storedPaths);
  }

  private function hasEmptyFields(): bool {
    return empty($this->studentId) || empty($this->departmentId) || empty($this->files['name'][0]);
  }

  private function storeAttachments(array $files, $studentId): array {
    $basePath = "../../assets/clearance-requirements/Users/$studentId/";
    if (!is_dir($basePath)) {
      mkdir($basePath, 0777, true);
    }

    $storedPaths = [];
    foreach ($files['tmp_name'] as $index => $tmpPath) {
      $originalName = basename($files['name'][$index]);
      $safeName = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
      $targetPath = $basePath . $safeName;

      if (move_uploaded_file($tmpPath, $targetPath)) {
        $storedPaths[] = "assets/clearance-requirements/Users/$studentId/$safeName";
      }
    }

    return $storedPaths;
  }
}
