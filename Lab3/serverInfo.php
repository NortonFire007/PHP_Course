<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: userLogin.php");
    exit;
}

echo "IP клієнта: " . $_SERVER['REMOTE_ADDR'] . "<br>";
echo "Браузер: " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
echo "Скрипт: " . $_SERVER['PHP_SELF'] . "<br>";
echo "Метод запиту: " . $_SERVER['REQUEST_METHOD'] . "<br>";
echo "Шлях до файлу: " . __FILE__ . "<br>";
