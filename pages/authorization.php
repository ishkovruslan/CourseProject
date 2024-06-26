<?php
session_start(); /* Початок сессії */
require_once ('header.php'); /* Верхня частина сайту */
?> 
<div class="main-block"><!-- Сторінка авторизації -->
    <h1>Форма авторизації</h1>
    <?php /* Якщо користувач вже авторизований -> відправити на index.php */
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<p>Ви вже авторизовані</p>";
        header("location: ../index.php");
    } else { /* В протилежному випадку запропонувати авторизуватись */
        if (isset($errorMessage)) {
            echo "<p>" . htmlspecialchars($errorMessage) . "</p>";
        }
        echo "<p>Ви ще не авторизовані</p>";
        ?><!-- Форма для авторизації -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Логін:</label><br>
            <input type="text" id="login" name="login"><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" name="login_submit" value="Зареєструватись">
        </form>
    <?php } ?>
</div>
<?php require_once ('../php/footer.php'); ?>