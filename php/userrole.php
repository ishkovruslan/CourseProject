<?php
function getUserRole($login) {
    $file = fopen('../data/userlist.csv', 'r');
    while (($row = fgetcsv($file)) !== false) {
        if ($row[0] === $login) {
            fclose($file);
            return $row[1];  // Повертаємо роль користувача
        }
    }
    fclose($file);
    return null; // Логін не знайдено
}
?>