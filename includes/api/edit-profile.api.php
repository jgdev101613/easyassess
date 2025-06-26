<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  require_once "../database/dbh.inc.php";
  require_once "../controller/EditProfileController.php";

  $id = $_SESSION['user']['id'];

  $data = [
    'first_name'   => $_POST['firstname'] ?? '',
    'middle_name'  => $_POST['middlename'] ?? '',
    'last_name'    => $_POST['lastname'] ?? '',
    'email'        => $_POST['email'] ?? '',
    'course'       => $_POST['course'] ?? '',
    'year_level'   => $_POST['year'] ?? '',
    'section'      => $_POST['section'] ?? '',
    'department'   => $_POST['department'] ?? '',
  ];

  $edit = new EditProfileController($conn, $id, $data);
  $result = $edit->updateProfile();

  echo json_encode($result);
  exit;
}
