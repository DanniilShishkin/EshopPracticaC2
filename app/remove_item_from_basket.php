<?php
require_once '../core/init.php';

$itemId = Cleaner::uint($_GET['id']);
Eshop::removeItemFromBasket($itemId);
header('Location: /basket');
?>
