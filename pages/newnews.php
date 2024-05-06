<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
require_once ('../php/highaccess.php'); /* Доступ лише у адміністраторів */
?>

<div class="main-block">
    <h1>Створити нову новину</h1>
    <form action="../php/createnews.php" method="POST" enctype="multipart/form-data">
        <label for="news_title">Назва новини:</label><br>
        <input type="text" id="news_title" name="news_title"><br><br>

        <label for="news_image">Зображення новини:</label><br>
        <input type="file" id="news_image" name="news_image" accept="image/*" required><br><br>

        <label for="news_description">Опис новини:</label><br>
        <textarea id="news_description" name="news_description" rows="4" cols="50"></textarea><br><br>

        <label for="start_date">Дата початку:</label><br>
        <input type="date" id="start_date" name="start_date"><br><br>

        <label for="end_date">Дата кінця:</label><br>
        <input type="date" id="end_date" name="end_date"><br><br>

        <input type="submit" value="Створити новину">
    </form>
</div>
</main>

<?php require_once ('../php/footer.php'); ?>