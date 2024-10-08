<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

echo "Привіт, " . htmlspecialchars($_SESSION['username']) . "!";
?>
<a href="logout.php">Вихід</a>
