<?php
require_once 'userrole.php'; /* Функція визначення ролі користувача */
require_once ('autocss.php'); /* Функція автоматичного додавання стилів відповідно до назви сторінки */
?>
<!DOCTYPE html>
<html lang="ukr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курсова робота</title>
    <link rel="stylesheet" type="text/css" href="../styles/global/style.css">
    <?php
    /* Визначення ролі користувача */
    if (isset($_SESSION['login'])) {
        $role = getUserRole($_SESSION['login']); /* Отримання ролі, якщо 'login' існує в сесії */
        if (!in_array($role, ['administrator', 'seller', 'user'])) {
            $role = 'user'; /* За замовчуванням, якщо немає ролі */
        }
    } else {
        $role = 'user'; /* За замовчуванням, якщо сесія або ключ 'login' відсутній */
    } /* Підключення CSS відповідно до ролі */ ?>
    <link rel="stylesheet" type="text/css" href="../styles/role/<?= htmlspecialchars($role); ?>.css">
</head>
<!-- Тіло з навігаційним меню -->

<body>
    <header>
        <img src="../images/global/Top.jpg" alt="Головне зображення">
    </header>
    <div class="PC">
        <img src="../images/global/PC.jpg" alt="Головне зображення">
        <a href="../server.php"> <?php echo date("Y-m-d"); ?></a>
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
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            /* Якщо це адміністратор - надати доступ до сторінок */
            $role = getUserRole($_SESSION['login']);
            if ($role === 'administrator') {
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
            if ($role === 'administrator' || $role === 'seller') {
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