<?php
require_once '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer = Cleaner::str($_POST['customer']);
    $email = Cleaner::str($_POST['email']);
    $phone = Cleaner::str($_POST['phone']);
    $address = Cleaner::str($_POST['address']);
    
    $items = Basket::getBasket();
    unset($items['order-id']); // Удаляем идентификатор заказа из массива

    $order = new Order($customer, $email, $phone, $address, $items);
    $order->id = uniqid();

    if (Eshop::saveOrder($order)) {
        header('Location: /create_order');
        exit();
    } else {
        echo "Ошибка при сохранении заказа.";
    }
} else {
    echo "Некорректный запрос.";
}
?>
