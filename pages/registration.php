<?php
session_start();
require_once ('../php/header.php'); /* Верхня частина сайту */
include ('../php/authentication.php');/* Функції які відповідають за реєстрацію */
?>
<div class="main-block">
    <h2>Форма реєстрації</h2>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
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
            <input type="submit" name="register_submit" value="Зареєструватись">
        </form>
    <?php } ?>
</div>
</main>
<?php require_once ('../php/footer.php'); ?>