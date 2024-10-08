<?php
session_start();
require_once 'database_connect.php';

$conn = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die('Усі поля повинні бути заповнені.');
    }

    $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE username = ?");
    if ($stmt === false) {
        die('Помилка підготовки запиту: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username;
            header('Location: welcome.php');
            exit;
        } else {
            die('Невірний пароль.');
        }
    } else {
        die('Користувач не знайдений.');
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);



