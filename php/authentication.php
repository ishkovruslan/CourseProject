<?php
class Authentication
{
    private $userFile;

    public function __construct($userFile)
    {
        $this->userFile = $userFile;
    }

    public function authenticate($login, $password)
    {
        $file = fopen($this->userFile, 'r');
        if ($file !== false) {
            while (($row = fgetcsv($file)) !== false) {
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

    public function isLoginUnique($login)
    {
        $file = fopen($this->userFile, 'r');
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] === $login) {
                fclose($file);
                return array('unique' => false, 'message' => "Цей логін вже використовується!");
            }
        }
        fclose($file);
        return array('unique' => true);
    }

    public function register($login, $password)
    {
        $checkLogin = $this->isLoginUnique($login);
        if (!$checkLogin['unique']) {
            return array('success' => false, 'message' => $checkLogin['message']);
        } else {
            $file = fopen($this->userFile, 'a');
            fputcsv($file, array($login, $password));
            fclose($file);

            // Додамо запис до файлу зі списком користувачів
            $fileUserList = fopen('../data/userlist.csv', 'a');
            fputcsv($fileUserList, array($login, 'user'));
            fclose($fileUserList);

            return array('success' => true);
        }
    }
}

$authentication = new Authentication('../data/users.csv');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_submit'])) { // Перевірка, чи була натиснута кнопка авторизації
        $login = $_POST['login'];
        $password = $_POST['password'];

        $result = $authentication->authenticate($login, $password);
        if ($result['success']) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['login'] = $login;
            header('Location: ../index.php');
            exit;
        } else {
            $errorMessage = $result['message'];
        }
    } elseif (isset($_POST['register_submit'])) { // Перевірка, чи була натиснута кнопка реєстрації
        $login = $_POST['login'];
        $password = $_POST['password'];

        $result = $authentication->register($login, $password);
        if ($result['success']) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['login'] = $login;
            header('Location: ../index.php');
            exit;
        } else {
            $errorMessage = $result['message'];
        }
    }
}
?>
