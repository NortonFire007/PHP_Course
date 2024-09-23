<?php
session_start();

$correct_username = 'admin';
$correct_password = '123';
$header_location = 'Location: userLogin.php';

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_destroy();
    header($header_location);
    exit();
}

$_SESSION['last_activity'] = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['user'] = $username;
        header($header_location);
        exit;
    } else {
        $error = 'Неправильний логін або пароль';
    }
}

if (isset($_SESSION['user'])) {
    echo "Привіт, " . htmlspecialchars($_SESSION['user']) . "!";
    echo '
    <form method="POST">
        <button type="submit" name="logout">Вихід</button>
    </form>';
    echo '
    <form method="GET" action="simpleShoppingCart.php">
        <button type="submit">Перейти в корзину</button>
    </form>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header($header_location);
    exit();
}

?>

<form method="POST">
    <label for="username">Логін:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit" name="login">Увійти</button>
</form>

<?php
if (isset($error)) {
    echo '<p style="color:red;">' . $error . '</p>';
}
?>

