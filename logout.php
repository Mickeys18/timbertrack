<?php
// Start the session so we can access it
session_start();

// Unset all session variables (clears the admin_id and admin_user)
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session on the server
session_destroy();

// Redirect the staff member back to the login page
header("Location: admin_login.php");
exit();
?>