<?php

class User {
    private $login;
    private $role;

    public function __construct($login, $role) {
        $this->login = $login;
        $this->role = $role;
    }

    public function changeRole($newRole) {
        $this->role = $newRole;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getRole() {
        return $this->role;
    }

    public function deleteUserItems() {
        $lines = file('../data/products.csv');
        $output = array();
        foreach ($lines as $line) {
            $data = explode(',', $line);
            if ($data[1] !== $this->login) {
                $output[] = $line;
            }
        }
        file_put_contents('../data/products.csv', implode('', $output));
    }
}

class UserList {
    private $users = [];

    public function loadUsersFromFile($filename) {
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $this->users[] = new User($data[0], $data[1]);
            }
            fclose($handle);
        }
    }

    public function saveUsersToFile($filename) {
        $file = fopen($filename, 'w');
        foreach ($this->users as $user) {
            fputcsv($file, [$user->getLogin(), $user->getRole()]);
        }
        fclose($file);
    }

    public function getUserByLogin($login) {
        foreach ($this->users as $user) {
            if ($user->getLogin() === $login) {
                return $user;
            }
        }
        return null;
    }

    public function deleteUserItems($login) {
        $user = $this->getUserByLogin($login);
        if ($user) {
            $user->deleteUserItems();
        }
    }

    public function getUsers() {
        return $this->users;
    }
}

// Використання класів
$userList = new UserList();
$userList->loadUsersFromFile("../data/userlist.csv");

if (isset($_POST['change_role'])) {
    $login = $_POST['login'];
    $new_role = $_POST['new_role'];

    $user = $userList->getUserByLogin($login);
    if ($user) {
        $user->changeRole($new_role);
        $userList->saveUsersToFile("../data/userlist.csv");

        if ($new_role === 'user') {
            $userList->deleteUserItems($login);
        }
    }

    header('Location: ../pages/management.php');
}

?>
