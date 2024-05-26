<?php
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../views/register_view.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($conn);

    if ($user->register($username, $password, $email)) {
        echo "Pendaftaran berhasil. Silakan <a href='login.php'>login</a>.";
    } else {
        echo "Error: tidak dapat mendaftar.";
    }

    mysqli_close($conn);
}
?>
