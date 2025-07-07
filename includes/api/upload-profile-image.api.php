<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profileImage']) && isset($_POST['userId'])) {
    $userIdRaw = $_POST['userId'];
    $userId = str_replace('-', '', $userIdRaw); // ✅ Remove dashes from userId

    $file = $_FILES['profileImage'];

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxFileSize = 30 * 1024 * 1024; // 30MB
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Validate
    if (!in_array($fileExt, $allowedExtensions)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        exit();
    }

    if ($file['size'] > $maxFileSize) {
        echo json_encode(['status' => 'error', 'message' => 'Image must be less than 30MB.']);
        exit();
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload error.']);
        exit();
    }

    // Save in structured path
    $uploadDir = "../../assets/Users/$userId/";
    $dbDirectory = "assets/Users/$userId/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = uniqid() . '.' . $fileExt;
    $targetPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save image.']);
        exit();
    }

    // Save path in DB
    $relativePath = $dbDirectory . $newFileName;

    require_once "../database/dbh.inc.php";
    $stmt = $conn->prepare("UPDATE users SET profile_image = :image WHERE id = :id");
    $stmt->execute([
        ':image' => $relativePath,
        ':id' => $userIdRaw
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Profile image updated.', 'path' => $relativePath]);
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
