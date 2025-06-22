<?php
require_once '../session/config.session.inc.php';
require_once '../database/dbh.inc.php';
require_once '../controller/FetchClearanceController.php';

if (!isset($_SESSION['user'])) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

$controller = new FetchClearanceController($conn);
echo json_encode($controller->getClearanceSubmissions($_SESSION['user']['department_id']));
