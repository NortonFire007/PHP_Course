<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профіль користувача</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Привіт, <?php echo htmlspecialchars($username); ?>!</h1>
<h2>Тут ви можете оновити свій профіль.</h2>
<form id="updateProfileForm">
    <label>Ім'я користувача</label>
    <input type="text" id="newUsername" name="newUsername" required>

    <label>Новий пароль</label>
    <input type="password" id="newPassword" name="newPassword">

    <button type="submit">Оновити профіль</button>
    <p id="profileMessage"></p>
</form>

<button id="logoutBtn">Вийти</button>

<script src="jquery-3.7.1.js"></script>
<script src="script.js"></script>
</body>
</html>
