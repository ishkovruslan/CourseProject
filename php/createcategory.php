<?php
if (isset($_POST['category_name']) && isset($_POST['category_description']) && isset($_POST['specifications'])) {
    /* Отримання данних з форми */
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];
    $specifications = $_POST['specifications'];
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
        /* Збереження в тимчасовому місці */
        $tmp_image_path = $_FILES['category_image']['tmp_name'];
        /* Генерація унікального імені */
        $image_name = uniqid() . "_" . $_FILES['category_image']['name'];
        $target_image_path = "../images/categories/" . $image_name;
        /* Переміщення з тимчасового місця */
        move_uploaded_file($tmp_image_path, $target_image_path);
        /* Збереження категорії */
        $data = array($category_name, $target_image_path, $category_description);
        $specificationsArray = explode(',', $specifications);
        $data = array_merge($data, $specificationsArray);
        $fp = fopen('../data/categories.csv', 'a');
        fputcsv($fp, $data);
        fclose($fp);
        echo "Категорія успішно створена!";
        header("location: ../pages/newcategory.php");
    } else {
        echo "Помилка: Зображення не було завантажено або сталася помилка під час завантаження.";
    }
} else {
    echo "Помилка: Недостатньо даних для створення категорії.";
}
?>