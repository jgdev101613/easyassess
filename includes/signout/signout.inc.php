<?php 

// Start the session
require_once "../session/config.session.inc.php";

session_unset();
session_destroy();
$message = 'Logged out successfully!';
$logout = ['status' => 'success', 'message' => $message];

// Return the response as JSON
echo json_encode($logout);
exit();