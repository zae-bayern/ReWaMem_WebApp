<?php
// Start the session to access it
session_start();

// Unset all session variables
$_SESSION = array();

// Also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <!-- Meta Tag: Redirect to index.php after 5 seconds -->
    <meta http-equiv="refresh" content="5;url=index.php">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
    </style>
</head>
<body>
    <p>You have been logged out. You will be redirected to the homepage in 5 seconds.</p>
    <p>If you are not redirected, <a href="index.php">click here</a> to return to the homepage.</p>
    <script>
        // Fallback JavaScript redirect
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>
</body>
</html>