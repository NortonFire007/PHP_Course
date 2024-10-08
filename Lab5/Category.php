<?php

class Category
{
    public $name;
    private $products = [];
    private $conn;

    public function __construct($name, $conn)
    {
        $this->name = $name;
        $this->conn = $conn;
    }

    public function getProducts()
    {
        if (empty($this->products)) {
            return "У категорії немає товарів.<br>";
        }

        $info = "Товари в категорії {$this->name}:<br>";
        foreach ($this->products as $product) {
            $info .= $product->getInfo();
        }
        return $info;
    }

    public function loadProducts()
    {
        $safe_name = mysqli_real_escape_string($this->conn, $this->name);

        $result = mysqli_query($this->conn, "SELECT * FROM products WHERE category_id = (SELECT id FROM categories WHERE name = '$safe_name')");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = new Product($row['name'], $row['price'], $row['description'], $row['category_id'], $this->conn);
                $this->products[] = $product;
            }
        }
    }
}
