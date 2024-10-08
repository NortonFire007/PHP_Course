<?php
require_once 'database_connect.php';

$conn = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        die('Усі поля повинні бути заповнені.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Невірний формат електронної пошти.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('Помилка підготовки запиту: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashedPassword);
    if (mysqli_stmt_execute($stmt)) {
        echo "Реєстрація успішна!";

        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.html";
                }, 3000); 
              </script>';
    } else {
        if (mysqli_stmt_errno($stmt) == 1062) {
            echo "Користувач із таким іменем або електронною поштою вже існує.";
        } else {
            die("Помилка: " . mysqli_stmt_error($stmt));
        }
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
