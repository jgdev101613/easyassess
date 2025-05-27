<?php 

ini_set('session.use_only_cookies', 1);
ini_set('session.use.strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 60 * 30, // 30 minutes
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

if (!isset($_SESSION['last_regeneration'])) {
  regenerate_session_id();
} else {
  $interval = 60 * 30; // 30 minutes
  if (time() - $_SESSION['last_regeneration'] >= $interval) {
    regenerate_session_id();
  }
}

function regenerate_session_id() {
  session_regenerate_id(true);
  $_SESSION['last_regeneration'] = time();
}