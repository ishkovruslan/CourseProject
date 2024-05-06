<?php
/* Запис файлів у .csv файл */
function writeCSV($filename, $data) {
    $fp = fopen($filename, 'w');
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
}

/* Запит на видалення товару */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];
    $itemsFile = '../data/products.csv';
    $items = readCSV($itemsFile);
    /* Пошук категорії товару для повернення назад */
    $category = $items[$productId][0];
    /* Видалення товару */
    unset($items[$productId]);
    /* Перезапис файлу */
    writeCSV($itemsFile, $items);
    /* Перенаправлення на категорію з якої видалили товар */
    header("Location: products.php?category=" . urlencode($category));
    exit();
}
?>