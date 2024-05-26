<?php
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../views/login_view.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($conn);
    $loggedInUser = $user->login($username, $password);

    if ($loggedInUser) {
        session_start();
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['username'] = $loggedInUser['username'];
        echo "Login berhasil. Selamat datang, " . $loggedInUser['username'] . "!";
    } else {
        echo "Username atau password salah.";
    }

    mysqli_close($conn);
}
?>
