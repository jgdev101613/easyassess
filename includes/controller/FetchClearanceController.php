<?php
declare(strict_types=1);

require_once '../model/Clearance.php';

class FetchClearanceController extends Clearance {
  private string $departmentId;

  public function __construct($db) {
    parent::__construct($db);
  }

  public function getClearanceSubmissions($department_id, $studentId = null) {
    return $this->fetchClearanceByDepartment($department_id, $studentId);
  }
}
