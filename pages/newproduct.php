<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
checkAccess(1); /* Доступ у адміністраторів та продавців */
?>

<div class="main-block">
    <h1>Створення нового товару</h1>
    <form id="productForm" action="../php/create.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category">Категорія:</label>
            <select name="category" id="category">
                <?php
                /* Отримання унікальних характеристик відповідно до категорії */
                $categories = array_map('str_getcsv', file('../data/categories.csv'));
                foreach ($categories as $category) {
                    echo '<option value="' . htmlspecialchars($category[0]) . '">' . htmlspecialchars($category[0]) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Назва товару:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Ціна:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
        </div>
        <div id="characteristics" class="form-group">
        </div>
        <div class="form-group">
            <label for="image">Зображення товару:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" name="create_product">Створити товар</button>
    </form>

    <script>
        document.getElementById("category").addEventListener("change", function () {
            var selectedCategory = this.value;
            var characteristicsDiv = document.getElementById("characteristics");
            characteristicsDiv.innerHTML = "";
            <?php
            $categories = array_map('str_getcsv', file('../data/categories.csv'));
            foreach ($categories as $category) {
                echo 'if (selectedCategory === "' . htmlspecialchars($category[0]) . '") {';
                for ($i = 3; $i <= 25; $i++) {
                    if (!empty($category[$i])) {
                        echo 'characteristicsDiv.innerHTML += \'<div class="form-group"><label for="characteristic_' . $i . '">' . htmlspecialchars($category[$i]) . ':</label><input type="text" name="characteristic_' . $i . '" id="characteristic_' . $i . '"></div>\';';
                    }
                }
                echo '}';
            }
            ?>
        });
    </script>
</div>
</main>
<?php require_once ('../php/footer.php'); ?>