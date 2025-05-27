<?php 
  require_once('../database/constant.php');
  require_once('../database/dbh.inc.php');

  function getAccountDetails($studentID) {
    global $conn;
    $stmt = $conn->prepare('
      SELECT * FROM students WHERE student_id = :studentId;
    ');

    $stmt->execute([
      'studentId' => $studentID,
    ]); 

    // Start the session
    require_once "../session/config.session.inc.php";

    if($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      regenerate_session_id();
      $_SESSION['student'] = [
        'student_id' => $row['student_id'],
        'student_name' => $row['student_name'],
        'student_email' => $row['student_email'],
        'student_phone' => $row['student_phone'],
        'created_at' => $row['created_at'],
      ];
    }
    
  }