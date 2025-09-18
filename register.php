<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username && $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        try {
            $stmt->execute(['username' => $username, 'password' => $hashed]);
            $_SESSION['user'] = $username;
            header("Location: add_product.php");
            exit;
        } catch (PDOException $e) {
            $error = "Username already taken.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Register</div>
        <div class="view-container">
            <form method="POST">
                <label>Username:</label><br>
                <input type="text" name="username" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Register</button>
            </form>

            <!-- Login düymesi -->
            <p style="margin-top:10px;">Already have an account? 
                <a href="login.php"><button type="button">Login</button></a>
            </p>

            <?php if(isset($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
