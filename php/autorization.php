<?php /* Авторизація */
function authenticate($login, $password)
{   /* Відкриття файлу з данними про користувачів */
    $file = fopen('../data/users.csv', 'r');
    if ($file !== false) {  /* Файл існує */
        while (($row = fgetcsv($file)) !== false) { /* Пошук користувача */
            if ($row[0] === $login && $row[1] === $password) {
                fclose($file);
                return array('success' => true);
            }
        }
        fclose($file);
    } else {
        return array('success' => false, 'message' => "Зверніться до адміністратора!");
    }
    return array('success' => false, 'message' => "Невірний логін або пароль!");
}

/* Очікування запиту */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    /* Авторизація */
    $result = authenticate($login, $password);
    if ($result['success']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['login'] = $login;
        header('Location: ../index.php');
        exit;
    } else {
        $errorMessage = $result['message'];
    }
}
?>