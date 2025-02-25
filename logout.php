<?php
// Unset user-specific cookies and destroy the session
unset($_SESSION['user_id']);
unset($_SESSION['auth_token']);
setcookie('auth_token', '', time() - 3600); // Expire the cookie
session_destroy();

// Redirect to the login page or another public page
header("Location: login.php");
exit();
?>