<?php
require_once 'database.php';
require_once 'validate.php';

function registerUser($username, $email, $password) {
    $db = Database_connect::getInstance()->getConnection();
    $response = ['success' => false, 'message' => ''];

    $validationError = validateForm($username, $email, $password);
    if ($validationError) {
        $response['message'] = $validationError;
        return $response;
    }

    $username = $db->real_escape_string($username);
    $email = $db->real_escape_string($email);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = $db->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $response['message'] = 'Користувач з такою електронною поштою вже існує.';
    } else {
        if ($db->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')") === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Реєстрація пройшла успішно.';
        } else {
            $response['message'] = 'Помилка при реєстрації: ' . $db->error;
        }
    }

    return $response;
}

function loginUser($email, $password)
{
    $db = Database_connect::getInstance()->getConnection();
    $response = ['success' => false, 'message' => '', 'username' => ''];

    $email = $db->real_escape_string($email);
    $result = $db->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $response['success'] = true;
            $response['username'] = $user['username'];
        } else {
            $response['message'] = 'Неправильний пароль.';
        }
    } else {
        $response['message'] = 'Користувач не знайдений.';
    }

    return $response;
}

function updateProfile($user_id, $newUsername, $newPassword)
{
    $db = Database_connect::getInstance()->getConnection();
    $response = ['success' => false, 'message' => ''];

    $newUsername = $db->real_escape_string($newUsername);
    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE users SET username='$newUsername', password='$newPassword' WHERE id='$user_id'";
    if ($db->query($query)) {
        $response['success'] = true;
        $response['message'] = 'Профіль оновлено успішно.';
    } else {
        $response['message'] = 'Помилка при оновленні профілю: ' . $db->error;
    }

    return $response;
}

function logoutUser()
{
    session_start();
    session_destroy();
    return ['success' => true, 'message' => 'Ви успішно вийшли.'];
}

