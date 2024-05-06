<?php
session_start();
require_once ('../php/header.php'); /* Запуск сессії */
include ('../php/csvreader.php'); /* Перетворення .csv файлу в масив */
include ('../php/deleteproduct.php');   /* Можливість видалення товару */
?>

<div class="main-block">
    <?php
    /* Ідентифікатор товару */
    $productId = $_GET['id'];
    $itemsFile = '../data/products.csv';
    $categoriesFile = '../data/categories.csv';
    $items = readCSV($itemsFile);
    $categories = readCSV($categoriesFile);
    /* Парсинг інформації */
    $item = $items[$productId];
    $categoryName = $item[0];
    $categoryIndex = array_search($categoryName, array_column($categories, 0));
    $category = $categories[$categoryIndex];
    $owner = $item[1];
    $itemName = $item[2];
    $price = $item[3];
    $imagePath = $item[4];
    /* Власник товару та адміністрація можуть видаляти товар */
    if (getUserRole($_SESSION['login']) === 'administrator' || $_SESSION['login'] == $owner) {
        $allow_delete = true;
    } else {
        $allow_delete = false;
    }
    /* Товари які виклав адміністратор закріплені за магазином */
    if (getUserRole($owner) == "administrator") {
        $owner = "Магазин";
    }
    ?>
    <div class="product-container">
        <img src="<?php echo $imagePath; ?>" alt="<?php echo $itemName; ?>" class="product-image">
        <div class="product-details">
            <h2><?php echo $itemName; ?></h2>
            <p>Продавець: <?php echo $owner; ?></p>
            <p>Ціна: <?php echo $price; ?></p>
            <h3>Характеристики:</h3>
            <ul>
                <?php
                /* Виведення характеристик товару */
                for ($i = 3; $i < count($item) - 2; $i++) {
                    /* Якщо характеристика відсутня - пропустити її */
                    if ($item[$i + 2] != '-') {
                        echo "<li>" . $categories[$categoryIndex][$i] . ": " . $item[$i + 2] . "</li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <?php if ($allow_delete): ?>
        <form method="post" action="">
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <button type="submit">Видалити товар</button>
        </form>
    <?php endif; ?>
</div>
</main>

<?php require_once ('../php/footer.php'); ?>