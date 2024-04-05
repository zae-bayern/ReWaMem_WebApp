<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}
?>

    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        #sites-list { margin-top: 20px; }
        .site { margin-bottom: 10px; padding: 10px; background-color: #f0f0f0; }
        form { margin-bottom: 20px; }
        input, button { margin: 5px 0; padding: 10px; }
        button { cursor: pointer; }
    </style> 

    <h2>Create New Site</h2>
    <form id="create-site-form">
        <input type="text" id="site-name" placeholder="Site Name" required>
        <textarea id="site-data" placeholder="Site Data" required></textarea>
        <button type="submit">Create Site</button>
    </form>

    <h2>My Sites</h2>
    <div id="sites-list">
        <!-- Sites will be added here by JavaScript -->
    </div>

    <script src="dashboard.js"></script>
<?php require_once('footer.php');?>