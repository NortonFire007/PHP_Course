<?php

class DiscountedProduct extends Product
{
    public $discount;

    public function __construct($name, $price, $description, $discount, $category_id, $conn)
    {
        parent::__construct($name, $price, $description, $category_id, $conn);
        $this->discount = $discount;
    }

    public function getInfo()
    {
        $discounted_price = $this->price - ($this->price * ($this->discount / 100));
        return "Назва: {$this->name}, Ціна зі знижкою: {$discounted_price}, Опис: {$this->description}<br>";
    }

    public function save()
    {
        $stmt = mysqli_prepare($this->conn, "INSERT INTO products (name, price, description, category_id, discount) VALUES (?, ?, ?, ?, ?)");
        $discounted_price = $this->price - ($this->price * ($this->discount / 100));
        mysqli_stmt_bind_param($stmt, "sdssi", $this->name, $discounted_price, $this->description, $this->category_id, $this->discount);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

