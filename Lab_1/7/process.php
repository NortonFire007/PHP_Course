<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);

    if (!empty($name) && !empty($surname)) {
        echo "Привіт, $name $surname!";
    } else {
        echo "Будь ласка, заповніть всі поля форми.";
    }
} else {
    echo "Дані не були отримані.";
}
?>
