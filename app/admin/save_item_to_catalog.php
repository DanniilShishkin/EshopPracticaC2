<?php
require_once '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = Cleaner::str($_POST['title']);
    $author = Cleaner::str($_POST['author']);
    $price = Cleaner::uint($_POST['price']);
    $pubyear = Cleaner::uint($_POST['pubyear']);

    $book = new Book($title, $author, $price, $pubyear);

    if (Eshop::addItemToCatalog($book)) {
        header('Location: add_item_to_catalog.php');
        exit();
    } else {
        echo "Ошибка при добавлении товара.";
    }
} else {
    echo "Некорректный запрос.";
}
?>
