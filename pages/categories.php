<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
include ('../php/csvreader.php');   /* Перетворення .csv файлу в масив */
$csvFile = '../data/categories.csv';
$categories = readCSV($csvFile);
?>

<div class="main-block">
    <?php
    $counter = 0;
    /* Виведення змісту категорії */
    foreach ($categories as $category) {
        $counter++;
        /* Пропуск першої категорії */
        if ($counter === 1) {
            continue;
        }
        $name = $category[0];
        $imagePath = $category[1];
        $description = $category[2];
        ?>
        <a href="products.php?category=<?php echo urlencode($name); ?>">
            <div class="category-box">
                <img src="<?php echo $imagePath; ?>" alt="<?php echo $name; ?>" class="category-image">
                <h3><?php echo $name; ?></h3>
                <p><?php echo $description; ?></p>
            </div>
        </a>
        <?php
    }
    ?>
</div>
</main>
<?php require_once ('../php/footer.php'); ?>