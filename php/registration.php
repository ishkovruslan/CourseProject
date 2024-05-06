<?php
/* Перевірка унікальності логіна */
function isLoginUnique($login)
{
    $file = fopen('../data/users.csv', 'r');
    while (($row = fgetcsv($file)) !== false) {
        if ($row[0] === $login) {
            fclose($file);
            return array('unique' => false, 'message' => "Цей логін вже використовується!");
        }
    }
    fclose($file);
    return array('unique' => true);
}
/* Запит на реєстрацію */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    /* Якщо передано логін та пароль */
    if (!empty($login) && !empty($password)) {
        /* Перевірка унікальності логіна */
        $checkLogin = isLoginUnique($login);
        if (!$checkLogin['unique']) {
            $errorMessage = $checkLogin['message'];
        } else {
            if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password)) {
                $errorMessage = "Пароль повинен містити мінімум 8 символів, включаючи цифри та символи різних регістрів!";
            } else {
                /* Запис нового користувача */
                $file = fopen('../data/users.csv', 'a');
                fputcsv($file, array($login, $password));
                fclose($file);
                /* Створення запису користувача з рівнем "користувач" */
                $fileUserList = fopen('../data/userlist.csv', 'a');
                fputcsv($fileUserList, array($login, 'user'));
                fclose($fileUserList);
                /* Автоматична авторизація */
                $_SESSION['loggedin'] = true;
                $_SESSION['login'] = $login;
                /* Відправка користувача на головну сторінку, звідти на mainpage.php */
                header('Location: ../index.php');
                exit;
            }
        }
    } else {
        $errorMessage = "Введіть логін та пароль!";
    }
}
?>