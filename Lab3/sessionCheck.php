<?php
function checkSessionActivity() {
    session_start();

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
        session_destroy();
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

$session_active = checkSessionActivity();
?>

<h1><?php echo $session_active ? "Сесія активна" : "Сесія неактивна"; ?></h1>

<?php if ($session_active): ?>
    <p>Ви можете продовжувати працювати.</p>
<?php else: ?>
    <p>Будь ласка, увійдіть знову.</p>
    <a href="userLogin.php">Увійти</a>
<?php endif; ?>
