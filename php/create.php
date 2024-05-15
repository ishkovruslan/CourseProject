<?php

class News
{
    public function create($title, $description, $startDate, $endDate, $image)
    {
        /* Збереження в тимчасовому місці */
        $tmp_image_path = $_FILES['news_image']['tmp_name'];
        /* Генерація унікального імені */
        $image_name = uniqid() . "_" . $_FILES['news_image']['name'];
        $target_image_path = "../images/news/" . $image_name;
        /* Переміщення з тимчасового місця */
        move_uploaded_file($tmp_image_path, $target_image_path);
        /* Збереження новини */
        $data = array($title, $target_image_path, $description, $startDate, $endDate);
        $fp = fopen('../data/news.csv', 'a');
        fputcsv($fp, $data);
        fclose($fp);
        echo "Новина успішно створена!";
        header("location: ../pages/newnews.php");
    }
}

class Category
{
    public function create($name, $description, $image, $specifications)
    {
        /* Збереження в тимчасовому місці */
        $tmp_image_path = $_FILES['category_image']['tmp_name'];
        /* Генерація унікального імені */
        $image_name = uniqid() . "_" . $_FILES['category_image']['name'];
        $target_image_path = "../images/categories/" . $image_name;
        /* Переміщення з тимчасового місця */
        move_uploaded_file($tmp_image_path, $target_image_path);
        /* Збереження категорії */
        $data = array($name, $target_image_path, $description);
        $specificationsArray = explode(', ', $specifications);
        $data = array_merge($data, $specificationsArray);
        $fp = fopen('../data/categories.csv', 'a');
        fputcsv($fp, $data);
        fclose($fp);
        echo "Категорія успішно створена!";
        header("location: ../pages/newcategory.php");
    }
}

class Product
{
    public function create($category, $name, $price, $image, $characteristics)
    {
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
        /* Збереження товару */
        $data = array($category, $_SESSION['login'], $name, $price, $uploadPath);
        $data = array_merge($data, $characteristics);
        $fp = fopen('../data/products.csv', 'a');
        fputcsv($fp, $data);
        fclose($fp);
        echo "Товар успішно додано!";
        header("Location: ../pages/newproduct.php");   
    }
}

// Використання класів

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_news'])) {
        $news = new News();
        $news->create($_POST['news_title'], $_POST['news_description'], $_POST['start_date'], $_POST['end_date'], $_FILES['news_image']);
    } elseif (isset($_POST['create_category'])) {
        $category = new Category();
        $category->create($_POST['category_name'], $_POST['category_description'], $_FILES['category_image'], $_POST['specifications']);
    } elseif (isset($_POST['create_product'])) {
        $product = new Product();
        $product->create($_POST['category'], $_POST['name'], $_POST['price'], $_FILES['image'], $_POST['characteristics']);
    }
}

?>