<?php
require_once ('../php/highaccess.php'); /* Перевірка рівня доступу */
?>

<!DOCTYPE html>
<html lang="ukr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курсова робота</title>
    <link rel="stylesheet" type="text/css" href="../styles/global/style.css">
    <!-- Автоматичні стилі з врахування назви сторінки та ролі користувача -->
    <?php
    /* Визначення ролі користувача */
    $current_page = basename($_SERVER['PHP_SELF'], '.php');
    if (isset($_SESSION['login'])) {
        $role = getUserRole($_SESSION['login']); /* Отримання ролі, якщо 'login' існує в сесії */
        if (getUserLevel($_SESSION['login']) == -1) {
            $role = 'user'; /* За замовчуванням, якщо немає ролі */
        }
    } else {
        $role = 'user'; /* За замовчуванням, якщо сесія або ключ 'login' відсутній */
    } ?>
    <link rel="stylesheet" type="text/css" href="../styles/role/<?= htmlspecialchars($role); ?>.css">
    <link rel="stylesheet" type="text/css" href="../styles/pages/<?= htmlspecialchars($current_page); ?>.css">
</head>
<!-- Тіло з навігаційним меню -->

<body>
    <header>
        <img src="../images/global/Top.jpg" alt="Головне зображення">
    </header>
    <div class="PC">
        <img src="../images/global/PC.jpg" alt="Головне зображення">
        <a href="../index.php"> <?php echo date("Y-m-d"); ?></a>
    </div>
    <div class="left"><!-- Загальнодоступні кнопки навігаційної панелі -->
        <p class="line">
            <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
            <a href="../index.php">Головна</a>
        </p>
        <p class="line">
            <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
            <a href="../pages/categories.php">Категорії</a>
        </p>
        <?php
        /* Перевірка авторизації користувача */
        if (isset($_SESSION['loggedin']) === true) {
            /* Якщо це адміністратор - надати доступ до сторінок */
            if (getUserLevel($_SESSION['login']) == 2) {
                ?>
                <p class="line">
                    <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
                    <a href="../pages/management.php">Сторінка керування</a>
                </p>
                <p class="line">
                    <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
                    <a href="../pages/newnews.php">Додати новину</a>
                </p>
                <p class="line">
                    <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
                    <a href="../pages/newcategory.php">Створити категорію</a>
                </p>
            <?php } ?>
            <?php
            /* Якщо користувач має роль адміністратора або продавця - надати доступ до створення товарів */
            if (getUserLevel($_SESSION['login']) >= 1) {
                ?>
                <p class="line">
                    <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
                    <a href="newproduct.php">Створити товар</a>
                </p>
            <?php } ?>
            <p class="line">
                <img src="../images/global/SoftLine.jpg" alt="М'яка лінія">
                <a href="../php/logout.php">Вийти</a>
            </p>
        <?php } else { /* Якщо користувач не авторизований - запропонувати показати кнопки авторизації та реєстрації */ ?>
            <p class="line">
                <img src="../images/global/SharpLine.jpg" alt="Гостра лінія">
                <a href="../pages/authorization.php">Авторизація</a>
            </p>
            <p class="line">
                <img src="../images/global/SoftLine.jpg" alt="М'яка лінія">
                <a href="../pages/registration.php">Реєстрація</a>
            </p>
        <?php } ?>
    </div>
</body>
<main>
    <div class="news-block">
        <div>
            <p><img src="../images/global/GreyLine.png" alt="Сіра лінія"></p>
            <p class="news-text">Новини</p>
        </div>
        <div class="events">
            <?php include 'newsblock.php'; ?> <!-- Вставляємо блоки новин -->
        </div>
    </div>