<?php
require_once '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = Cleaner::str($_POST['login']);
    $password = Eshop::createHash(Cleaner::str($_POST['password']));
    $email = Cleaner::str($_POST['email']);

    $user = new User($login, $password, $email);

    if (Eshop::userAdd($user)) {
        header('Location: create_user.php');
        exit();
    } else {
        echo "Ошибка при добавлении пользователя.";
    }
} else {
    echo "Некорректный запрос.";
}
?>
