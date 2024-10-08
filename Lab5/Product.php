<?php

class Product
{
    public $name;
    public $price;
    public $description;
    protected $category_id;
    protected $conn;

    public function __construct($name, $price, $description, $category_id, $conn)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->conn = $conn;
    }

    public function getInfo()
    {
        return "Назва: {$this->name}, Ціна: {$this->price}, Опис: {$this->description}<br>";
    }

    public function save()
    {
        $stmt = mysqli_prepare($this->conn, "INSERT INTO products (name, price, description, category_id) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sdsi", $this->name, $this->price, $this->description, $this->category_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
