<?php
if (isset($_POST['news_title']) && isset($_POST['news_description']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
    /* Отримання данних з форми */
    $news_title = $_POST['news_title'];
    $news_description = $_POST['news_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] === UPLOAD_ERR_OK) {
        /* Збереження в тимчасовому місці */
        $tmp_image_path = $_FILES['news_image']['tmp_name'];
        /* Генерація унікального імені */
        $image_name = uniqid() . "_" . $_FILES['news_image']['name'];
        $target_image_path = "../images/news/" . $image_name;
        /* Переміщення з тимчасового місця */
        move_uploaded_file($tmp_image_path, $target_image_path);
        /* Збереження новини */
        $data = array($news_title, $target_image_path, $news_description, $start_date, $end_date);
        $fp = fopen('../data/news.csv', 'a');
        fputcsv($fp, $data);
        fclose($fp);
        echo "Новина успішно створена!";
        header("location: ../pages/newnews.php");
    } else {
        echo "Помилка: Зображення не було завантажено або сталася помилка під час завантаження.";
    }
} else {
    echo "Помилка: Недостатньо даних для створення новини.";
}
?>
