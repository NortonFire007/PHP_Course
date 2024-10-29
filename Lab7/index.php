<?php
session_start();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="jquery-3.7.1.js"></script>
    <script src="script.js"></script>
    <title>Головна</title>
</head>
<body>
<div class="container">
    <h2>Головна сторінка</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Привіт, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <button id="profileBtn">Профіль</button>
        <button id="logoutBtn">Вийти</button>
    <?php else: ?>
        <button id="loginBtn">Увійти</button>
        <button id="registerBtn">Зареєструватися</button>
    <?php endif; ?>

    <div id="message" class="message"></div>
</div>
</body>
</html>





