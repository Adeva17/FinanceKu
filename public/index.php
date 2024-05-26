<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "Selamat datang, " . $_SESSION['username'] . "!";
    echo "<br><a href='logout.php'>Logout</a>";
} else {
    echo "<a href='login.php'>Login</a> atau <a href='register.php'>Daftar</a>";
}
?>
