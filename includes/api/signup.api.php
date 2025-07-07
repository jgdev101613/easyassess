<?php 

declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerUserId'])) {
  
  // User Auth
  $userIdRaw = $_POST["registerUserId"];
  $email = $_POST["registerEmail"];
  $password = $_POST["registerPassword"];
  $repassword = $_POST["registerRePassword"];
  $user_type = "student"; // or get from $_POST if needed

  $userId = str_replace('-', '', $userIdRaw); // ✅ Remove dashes from userId

  // User Detaiols
  $firstName = $_POST["registerFirstName"];
  $middleName = $_POST["registerMiddleName"];
  $lastName = $_POST["registerLastName"];

  if (isset($_FILES['registerPhoto']) && $_FILES['registerPhoto']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['registerPhoto']['tmp_name'];
    $fileName = $_FILES['registerPhoto']['name'];
    $fileSize = $_FILES['registerPhoto']['size'];
    $fileType = $_FILES['registerPhoto']['type'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $maxFileSize = 30 * 1024 * 1024; // 30MB
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if ($fileSize > $maxFileSize) {
      echo json_encode(['status' => 'error', 'message' => 'Image must be less than 30MB.']);
      exit();
    }

    if (!in_array($fileExt, $allowedExtensions)) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid image file type.']);
      exit();
    }

    // Create folder if not exists
    $uploadDir = "../../assets/Users/$userId/";
    $dbDirectory = "assets/Users/$userId/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $newFileName = uniqid() . '.' . $fileExt;
    $registerPhoto = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmpPath, $registerPhoto)) {
      echo json_encode([
          'status' => 'error',
          'message' => 'Failed to move uploaded file.'
      ]);
      exit();
    }

    $profile_image = $dbDirectory . $newFileName;


    // Instantiate signup controller
    include_once "../database/dbh.inc.php";
    include_once "../controller/SignUpController.php";
    
    // Initialize your database connection
    $db = $conn; 
    
    $signup = new SignUpController($db, $userId, $user_type, $email, $password, $repassword, $profile_image, $firstName, $middleName, $lastName);
    $response = $signup->signupUser();

    // Running Error handling
    if ($response['status'] === 'success') {
      //accountActivatedEmail($accountType, $accountEmail);
      
      $message = 'Registered Successfully! Please check your email for activation link.';
      $response = ['status' => 'success', 'message' => $message];
    } else {
      $message = $response['message'];
      $response = ['status' => 'error', 'message' => $message];
    }

    // Going back to frontpage
    echo json_encode($response);
    exit();

  }

  
}