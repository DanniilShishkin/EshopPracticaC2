<?php
require_once '../core/init.php';

$itemId = Cleaner::uint($_GET['id']);
Eshop::addItemToBasket($itemId, 1);
header('Location: /basket');
?>
