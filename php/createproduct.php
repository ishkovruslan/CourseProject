<?php
session_start();
/* Додавання нового товару */
function addProductToCSV($data, $filename)
{
    $fp = fopen($filename, 'a');
    fputcsv($fp, $data);
    fclose($fp);
}

/* Перевірка запиту */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Отримання данних з форми */
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];
    $characteristics = array();
    /* Отримання унікальних характеристик товару */
    for ($i = 1; $i <= 25; $i++) {
        if (!empty($_POST['characteristic_' . $i])) {
            $characteristics[] = $_POST['characteristic_' . $i];
        }
    }
    /* Збереження товару */
    $uploadDir = '../images/products/';
    $uploadPath = $uploadDir . $image;
    move_uploaded_file($tempImage, $uploadPath);
    $productData = array($category, $_SESSION['login'], $name, $price, $uploadPath);
    $productData = array_merge($productData, $characteristics);
    addProductToCSV($productData, '../data/products.csv');
    header("Location: ../pages/newproduct.php");
    exit();
}
?>