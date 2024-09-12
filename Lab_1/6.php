<?php
$student = [
    "name" => "Олександр",
    "surname" => "Іваненко",
    "age" => 20,
    "speciality" => "Комп'ютерні науки"
];

echo "Ім'я: " . $student["name"] . "<br>";
echo "Прізвище: " . $student["surname"] . "<br>";
echo "Вік: " . $student["age"] . "<br>";
echo "Спеціальність: " . $student["speciality"] . "<br>";

$student["average rating"] = 4.5;

print_r($student);
?>
