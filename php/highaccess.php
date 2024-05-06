<?php /* Перевірка ролі, якщо роль не адміністратор перенаправлення на index.php, звідти на mainpage.php */
$role = getUserRole($_SESSION['login']);
if ($role !== 'administrator') {
    header("location: ../index.php");
}
?>