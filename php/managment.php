<?php
/* Збереження змін у файлі користувачів */
function saveUserList($users)
{
    $file = fopen('../data/userlist.csv', 'w');
    foreach ($users as $user) {
        fputcsv($file, $user);
    }
    fclose($file);
}

/* Видалення товарів користувача в разі зміни ролі з "Продавець" на "Користувач" */
function deleteUserItems($login)
{
    $lines = file('../data/products.csv'); /* Зчитування усіх рядків файлу */
    $output = array(); /* Масив для зберігання відфільтрованих рядків */
    foreach ($lines as $line) {
        $data = explode(',', $line); /* Розбиваємо рядок на масив */
        if ($data[1] !== $login) { /* Перевіряємо, чи не співпадає логін */
            $output[] = $line; /* Якщо логін не співпадає, додаємо рядок до масиву */
        }
    }/* Зберігаємо вміст файлу без рядків з відповідним логіном */
    file_put_contents('../data/products.csv', implode('', $output));
}

/* Зчитування користувачів з файлу userlist.csv */
$users = [];
if (($handle = fopen("../data/userlist.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $users[] = $data;
    }
    fclose($handle);
}

/* Обробка запиту на зміну ролі користувача */
if (isset($_POST['change_role'])) {
    $login = $_POST['login'];
    $new_role = $_POST['new_role'];
    /* Зміна ролі користувача в масиві $users */
    foreach ($users as &$user) {
        if ($user[0] === $login) {
            $user[1] = $new_role;
            break;
        }
    }
    /* Збереження оновленого списку користувачів у файлі */
    saveUserList($users);
    /* Якщо нова роль користувача - "user", видаляємо його товари */
    if ($new_role === 'user') {
        deleteUserItems($login);
    }
    header('Location: ../pages/management.php');
}

?>