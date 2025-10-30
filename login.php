<?php
require 'security.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['_csrf'] ?? '';

    if (!verify_csrf($token)) {
        $error = "Invalid request.";
    } else {
        $stmt = $pdo->prepare("SELECT username, password FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // login
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Login</div>
        <div class="view-container">
            <form method="POST" novalidate>
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                <label>Username:</label><br>
                <input type="text" name="username" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Login</button>
            </form>

            <p style="margin-top:10px;">Don't have an account?
                <a href="register.php"><button type="button">Register</button></a>
            </p>

            <?php if (isset($error)): ?>
                <p style="color:red;"><?= e($error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
