<?php
require_once '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = Cleaner::str($_POST['login']);
    $password = Cleaner::str($_POST['password']);

    $user = new User($login, $password, null);

    if (Eshop::userCheck($user)) {
        Eshop::logIn($login);
        header('Location: admin.php');
        exit();
    } else {
        echo "Неверный логин или пароль.";
    }
} else {
    echo "Некорректный запрос.";
}
?>
