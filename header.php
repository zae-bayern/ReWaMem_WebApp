<?php session_start(); ?>
<!DOCTYPE html>
<html land="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TextilDB</title>
  </head>
<body>
<header>
    <img src="logo.png" alt="Logo" style="height: 50px;"> <!-- Path to your logo -->
    <nav>
        <?php if(isset($_SESSION['username'])): ?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data-visualization.php">Data Visualization</a></li>
                <!-- Add more links as needed -->
            </ul>
        <?php endif; ?>
    </nav>
    <div class="user-info">
        <?php if(isset($_SESSION['username'])): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php">Logout</a> <!-- Path to your logout script -->
        <?php else: ?>
            <a href="login.php">Login</a> <!-- Path to your login page -->
        <?php endif; ?>
    </div>
</header>
