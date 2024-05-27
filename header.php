<?php session_start(); ?>
<!DOCTYPE html>
<html land="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ReWaMem TextilDB</title>
  </head>
<body>
<header>
    <img src="logo.png" alt="Logo" class="header-logo" style="height: 50px;"> 
    <nav style="padding-right: 40vw; padding-left: 15px;">
        <?php if(isset($_SESSION['user_id'])): ?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data-visualization.php">Data Visualization</a></li>
                <!-- more links as needed -->
            </ul>
        <?php endif; ?>
    </nav>
    <div class="user-info">
        <?php if(isset($_SESSION['user_id'])): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php">Logout</a> 
        <?php else: ?>
            <?php if(basename($_SERVER['PHP_SELF']) != 'login.php'): ?>
                <a href="login.php">Login</a> 
            <?php else: ?>
                <p>Please log in to continue.</p> <!-- Message on the login page -->
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>
<div class="container">