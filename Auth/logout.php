<?php
session_start();

// Clear all cookies
foreach ($_COOKIE as $key => $value) {
    // Set the cookie with an expiration date in the past
    setcookie($key, '', time() - 3600, '/'); // The '/' indicates that the cookie is available in the entire domain
}

// Optionally, you can also clear session data
$_SESSION = []; // Clear session data
session_destroy(); // Destroy the session

echo 'All cookies have been cleared.';
header('location: login.php')
?>