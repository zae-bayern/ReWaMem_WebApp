<?php require_once("header.php"); ?>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        form { display: flex; flex-direction: column; width: 300px; }
        input, button { margin-bottom: 10px; padding: 10px; }
        button { cursor: pointer; }
    </style>
    <form action="backend/login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

<?php require_once("footer.php"); ?>