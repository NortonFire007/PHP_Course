<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $username = htmlspecialchars(trim($_POST['username']));
        setcookie('username', $username, time() + (7 * 24 * 60 * 60));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['delete_cookie'])) {
        setcookie('username', '', time() - 3600);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<?php
if (isset($_COOKIE['username'])) {
    echo "Привіт, " . htmlspecialchars($_COOKIE['username']) . "!";
    echo '<form method="POST">
                <button type="submit" name="delete_cookie">Видалити кукі</button>
              </form>';
} else {
    ?>
    <form method="POST">
        <label for="username">Ваше ім'я:</label>
        <input type="text" name="username" id="username" required>
        <button type="submit">Зберегти</button>
    </form>
    <?php
}
?>
