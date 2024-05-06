<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
include ('../php/csvreader.php'); /* Перетворення .cvs в масив */
?>

<div class="main-block">
    <form method="get">
        <select name="roleFilter"><!-- Фільтрація за продавцем, ціною -->
            <option value="anyone" <?php echo (!isset($_GET['roleFilter']) || (isset($_GET['roleFilter']) && $_GET['roleFilter'] == 'anyone')) ? 'selected' : ''; ?>>Будь-хто</option>
            <option value="store" <?php echo (isset($_GET['roleFilter']) && $_GET['roleFilter'] == 'store') ? 'selected' : ''; ?>>Магазин</option>
        </select>
        <input type="hidden" name="category"
            value="<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?>">
        <input type="text" name="minPrice" placeholder="Мін. вартість"
            value="<?php echo isset($_GET['minPrice']) ? htmlspecialchars($_GET['minPrice']) : ''; ?>">
        <input type="text" name="maxPrice" placeholder="Макс. вартість"
            value="<?php echo isset($_GET['maxPrice']) ? htmlspecialchars($_GET['maxPrice']) : ''; ?>">
        <select name="sort">    <!-- Сортування за ціною -->
            <option value="asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'selected' : ''; ?>>Від
                меншої до більшої ціни</option>
            <option value="desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'selected' : ''; ?>>Від
                більшої до меншої ціни</option>
        </select>
        <button type="submit">Фільтрувати</button>
        <a href="products.php" onclick="resetFilters(event)">Скинути</a>
    </form>

    <?php
    $category = $_GET['category'] ?? 'defaultCategory';
    $csvFile = '../data/products.csv';
    $items = readCSV($csvFile);
    $roleFilter = $_GET['roleFilter'] ?? 'anyone';
    $minPrice = !empty($_GET['minPrice']) ? $_GET['minPrice'] : null;
    $maxPrice = !empty($_GET['maxPrice']) ? $_GET['maxPrice'] : null;
    $sort = !empty($_GET['sort']) ? $_GET['sort'] : null;

    /* Сортування за ціною */
    usort($items, function ($a, $b) use ($sort) {
        if ($sort === 'asc') {
            return $a[3] <=> $b[3];
        } elseif ($sort === 'desc') {
            return $b[3] <=> $a[3];
        }
        return 0;
    });

    foreach ($items as $key => $item) {
        if ($item[0] === $category) {
            $owner = $item[1];
            $itemName = $item[2];
            $price = $item[3];
            $imagePath = $item[4];

            /* Товари які виклав адміністратор закріплені за магазином */
            $role = getUserRole($owner);
            if ($role == "administrator") {
                $owner = "Магазин";
            }

            /* Фільтрація за продавцем */
            if ($roleFilter == 'store' && $owner != 'Магазин') {
                continue;
            }

            /* Фільтрація за вартістью */
            if (($minPrice !== null && $price < $minPrice) || ($maxPrice !== null && $price > $maxPrice)) {
                continue;
            }

            /* Генерація сторінки */
            ?>
            <a href="product.php?id=<?php echo $key; ?>">
                <div class="product-box">
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $itemName; ?>" class="product-image">
                    <h3><?php echo $itemName; ?></h3>
                    <p>Власник: <?php echo $owner; ?></p>
                    <p>Ціна: <?php echo $price; ?></p>
                </div>
            </a>
            <?php
        }
    }
    ?>
</div>
</main>
<?php require_once ('../php/footer.php'); ?>

<script>    /* Скидання фільтрів */
    function resetFilters(event) {
        event.preventDefault();
        var category = document.querySelector('input[name="category"]').value;
        document.querySelector('select[name="roleFilter"]').value = 'anyone';
        document.querySelector('input[name="minPrice"]').value = '';
        document.querySelector('input[name="maxPrice"]').value = '';
        document.querySelector('select[name="sort"]').value = 'asc';
        window.location.href = 'products.php?category=' + encodeURIComponent(category);
    }
</script>