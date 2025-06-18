<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// 🔧 Secure cookie settings
session_set_cookie_params([
    'lifetime' => 3600 * 24, // 24 hours
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']), // true if HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);

// ✅ Start session
session_start();

// ✅ Move function UP here
function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// ✅ Regenerate ID if needed
if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id();
} else {
    $interval = 60 * 5; // 5 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session_id();
    }
}
