<?php
$header_location = 'Location: simpleShoppingCart.php';

session_start();

if (!isset($_SESSION['user'])) {
    echo "Будь ласка, увійдіть до системи, щоб додати товари до корзини.<br>";
    echo '<a href="userLogin.php">Увійти</a>';
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['item']) && !empty(trim($_POST['item']))) {
        $_SESSION['cart'][] = $_POST['item'];
        setcookie('previous_cart', serialize($_SESSION['cart']), time() + 30 * 24 * 60 * 60);
        header($header_location);
        exit();
    }

    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        setcookie('previous_cart', '', time() - 3600);
        header($header_location);
        exit();
    }
}

if (isset($_COOKIE['previous_cart'])) {
    $_SESSION['cart'] = unserialize($_COOKIE['previous_cart']);
}

if (!empty($_SESSION['cart'])) {
    echo "Товари в корзині: " . implode(", ", $_SESSION['cart']);
} else {
    echo "Ваша корзина порожня.";
}
?>

<form method="POST">
    <label for="item">Додати товар:</label>
    <input type="text" name="item" id="item" required>
    <button type="submit">Додати до корзини</button>
</form>

<form method="POST">
    <button type="submit" name="clear_cart">Очистити корзину</button>
</form>