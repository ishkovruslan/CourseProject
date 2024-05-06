<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
require_once ('../php/highaccess.php'); /* Доступ лише у адміністраторів */
?>

<div class="main-block">
    <h2>Створити нову категорію</h2>
    <form action="../php/createcategory.php" method="POST" enctype="multipart/form-data">
        <label for="category_name">Назва категорії:</label><br>
        <input type="text" id="category_name" name="category_name"><br><br>

        <label for="category_description">Опис категорії:</label><br>
        <textarea id="category_description" name="category_description" rows="4" cols="50"></textarea><br><br>

        <label for="category_image">Зображення категорії:</label><br>
        <input type="file" id="category_image" name="category_image" accept="image/*" required><br><br>
        
        <label for="specifications">Специфікації (розділені комою):</label><br>
        <textarea id="specifications" name="specifications" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Створити категорію">
    </form>
</div>
</main>

<?php require_once ('../php/footer.php'); ?>