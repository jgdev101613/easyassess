<?php
// ==== HANDLE AJAX REQUEST ====

require_once "../model/Email.php";
require_once "../database/dbh.inc.php";

$db = $conn;
$mailer = new AccountMailer($db);

// Sample structure: action=activate, email=abc@example.com, etc.
$action = $_POST['action'] ?? '';
$response = ['status' => 'error', 'message' => 'Invalid request'];

switch ($action) {
    case 'activate':
        $response = $mailer->handleActivation(
            $_POST['email'],
            $_POST['type'],
            $_POST['status']
        );
        break;

    case 'deactivate':
        $response = $mailer->handleDeactivation(
            $_POST['userID'],
            $_POST['email'],
            $_POST['type'],
            $_POST['status']
        );
        break;

    case 'register':
        $res = $mailer->sendRegistrationEmail($_POST['type'], $_POST['email']);
        $response = ['status' => 'success', 'message' => 'Registration email sent.', 'get' => $res];
        break;

    case 'forgot':
        $mailer->sendForgotPasswordEmail($_POST['link'], $_POST['email']);
        $response = ['status' => 'success', 'message' => 'Password reset email sent.'];
        break;
}

echo json_encode($response);
exit;
