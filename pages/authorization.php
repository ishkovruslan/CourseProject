<?php
session_start();
require_once ('../php/autorization.php');   /* Авторизація користувача */
require_once ('../php/header.php'); ?>  <!-- Верхня частина сайту -->
<div class="main-block">
    <h2>Форма авторизації</h2>
    <?php /* Якщо користувач вже авторизований - відправити на index.php */
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<p>Ви вже авторизовані</p>";
        header("location: ../index.php");
    } else {
        if (isset($errorMessage)) {
            echo "<p>" . htmlspecialchars($errorMessage) . "</p>";
        }
        echo "<p>Ви ще не авторизовані</p>";
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Логін:</label><br>
            <input type="text" id="login" name="login"><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Увійти">
        </form>
    <?php } ?>
</div>
</main>
<?php require_once ('../php/footer.php'); ?>