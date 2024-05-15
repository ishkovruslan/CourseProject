<?php
function getUserRole($login)
{
    $file = fopen('../data/userlist.csv', 'r');
    while (($row = fgetcsv($file)) !== false) {
        if ($row[0] === $login) {
            fclose($file);
            return $row[1];  // Повертаємо роль користувача
        }
    }
    fclose($file);
    return 'unauthorized'; // Логін не знайдено, роль - неавторизований користувач
}

function getUserLevel($login)
{
    // Отримуємо роль користувача
    $role = getUserRole($login);

    // Значення ролі користувача відповідно до $roles з checkAccess
    $roles = [
        'user' => 0,
        'seller' => 1,
        'administrator' => 2
    ];

    // Повертаємо числове значення ролі користувача згідно масиву $roles
    return isset($roles[$role]) ? $roles[$role] : -1;
}

function checkAccess($minRequiredRole)
{
    $roles = [
        'user' => 0,
        'seller' => 1,
        'administrator' => 2
    ];

    // Перевірка, чи користувач авторизований
    if (!isset($_SESSION['login'])) {
        header("location: ../index.php");
        exit;
    }

    $role = getUserRole($_SESSION['login']);

    // Перевірка, чи роль користувача вища або дорівнює мінімальному рівню доступу
    if (!isset($roles[$role]) || $roles[$role] < $minRequiredRole) {
        header("location: ../index.php");
        exit;
    }
}
?>