<?php
session_start(); /* Почати сесію */
/* Завершити сесію */
$_SESSION = array(); /* Очистити змінні сесії */
session_destroy(); /* Закрити сесію */
/* Перенаправити користувача на сторінку авторизації */
header("location: ../pages/authorization.php");
exit;
?>