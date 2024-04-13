<?php require_once("header.php"); ?>

    <style>
        form { display: flex; flex-direction: column; width: 300px; }
        input, button { margin-bottom: 10px; padding: 10px; }
        button { cursor: pointer; }
    </style>
    <div style="display: flex; align-items: center; justify-content: center; height: 80vh; width: 100vw;">
        <form action="backend/login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

<?php require_once("footer.php"); ?>