<?php
require_once 'Product.php';
require_once 'DiscountedProduct.php';
require_once 'Category.php';

$db_host = 'mysql';
$db_user = getenv('MYSQL_DB_USERNAME');
$db_pass = getenv('MYSQL_DB_PASSWORD');
$db_name = getenv('MYSQL_DB_DATABASE');

function connectDB($host, $user, $pass, $db)
{
    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        throw new Exception("Помилка підключення до бази даних: " . mysqli_connect_error());
    }
    return $conn;
}

try {
    $conn = connectDB($db_host, $db_user, $db_pass, $db_name);

    // Получение категорий
    $category_query = "SELECT DISTINCT name FROM categories";
    $category_result = mysqli_query($conn, $category_query);
    if (!$category_result) {
        throw new Exception("Помилка виконання запиту: " . mysqli_error($conn));
    }

    $categories = [];
    while ($row = mysqli_fetch_assoc($category_result)) {
        $categories[] = $row['name'];
    }

    $selected_category = null;
    $products_info = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Добавление новой категории
        if (isset($_POST['new_category'])) {
            $new_category = mysqli_real_escape_string($conn, $_POST['new_category']);
            $insert_category_query = "INSERT INTO categories (name) VALUES ('$new_category')";

            if (!mysqli_query($conn, $insert_category_query)) {
                throw new Exception("Помилка додавання категорії: " . mysqli_error($conn));
            }

            header("Location: index.php");
            exit;
        }

        // Добавление обычного товара
        if (isset($_POST['regular_product'])) {
            $product_name = mysqli_real_escape_string($conn, $_POST['regular_product_name']);
            $product_price = (float)$_POST['regular_product_price'];
            $product_description = mysqli_real_escape_string($conn, $_POST['regular_product_description']);
            $category_name = mysqli_real_escape_string($conn, $_POST['category']);

            $category_id_query = "SELECT id FROM categories WHERE name = ?";
            $stmt = mysqli_prepare($conn, $category_id_query);
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['id'];
            } else {
                throw new Exception("Категорія не знайдена.");
            }

            $regular_product = new Product($product_name, $product_price, $product_description, $category_id, $conn);
            $regular_product->save();

            echo "<p>Звичайний товар додано успішно!</p>";
        }
        
        if (isset($_POST['discounted_product'])) {
            $product_name = mysqli_real_escape_string($conn, $_POST['discounted_product_name']);
            $product_price = (float)$_POST['discounted_product_price'];
            $product_description = mysqli_real_escape_string($conn, $_POST['discounted_product_description']);
            $product_discount = (float)$_POST['product_discount'];
            $category_name = mysqli_real_escape_string($conn, $_POST['category_discount']);

            $category_id_query = "SELECT id FROM categories WHERE name = ?";
            $stmt = mysqli_prepare($conn, $category_id_query);
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['id'];
            } else {
                throw new Exception("Категорія не знайдена.");
            }

            $discounted_product = new DiscountedProduct($product_name, $product_price, $product_description, $product_discount, $category_id, $conn);
            $discounted_product->save();

            echo "<p>Товар зі знижкою додано успішно!</p>";
        }

        if (isset($_POST['category'])) {
            $selected_category = mysqli_real_escape_string($conn, $_POST['category']);
            $category = new Category($selected_category, $conn);
            $category->loadProducts();
            $products_info = $category->getProducts();
        }
    }
} catch (Exception $e) {
    echo "<p>Виникла помилка: " . $e->getMessage() . "</p>";
    exit;
}

include 'index.html';

