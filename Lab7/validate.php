<?php
function validateForm($username, $email, $password, $confirmPassword = null)
{
    if (!validateEmail($email)) {
        return "Невірний формат електронної пошти";
    }

    if (!validateUsername($username)) {
        return "Ім'я користувача повинно бути від 3 до 15 символів і містити тільки букви, цифри та підкреслення";
    }

    if (!validatePassword($password)) {
        return "Пароль повинен бути не менше 8 символів, містити хоча б одну велику літеру, одну малу літеру і одну цифру";
    }

    if ($confirmPassword !== null && $password !== $confirmPassword) {
        return "Паролі не співпадають";
    }

    return null;
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateUsername($username)
{
    return preg_match('/^[a-zA-Z0-9_]{3,15}$/', $username);
}

function validatePassword($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password);
}
