<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}
?>

    <div id="data-display"></div>
    <div id="plotly-chart" style="width:100%;max-width:700px;height:500px;"></div>

    <script src="data-visualization.js"></script>
<?php require_once('footer.php');?>