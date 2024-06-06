<?php
session_start();
require 'dbconn.php'; // assuming getConnection function is in db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = getConnection();

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
        $_SESSION['userId'] = $user['id'];
        $_SESSION['nickname'] = $user['nickname']; 
        header('Location: dashboard.php');
        exit;
    } else {
        // Invalid credentials
        $error = 'Invalid email or password';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeku - Login</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Financeku.</h1>
        <p>Teman Financemu!</p>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="button-container">
                <button type="submit">Login</button>
                <a href="register.php" class="signup-link">Sign Up</a>
            </div>
        </form>
    </div>
</body>
</html>
