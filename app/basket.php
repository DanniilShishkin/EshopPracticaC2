<?php
require_once 'core/init.php';
require_once 'app/__header.php';

echo "<p>Вернуться в <a href='/catalog'>каталог</a></p>";
echo "<h1>Ваша корзина</h1>";
echo "<table>
        <tr>
            <th>N п/п</th>
            <th>Название</th>
            <th>Автор</th>
            <th>Год издания</th>
            <th>Цена, руб.</th>
            <th>Количество</th>
            <th>Удалить</th>
        </tr>";

$total = 0;
$counter = 1;
try {
    $items = Eshop::getItemsFromBasket();
    foreach ($items as $item) {
        $quantity = Basket::getBasket()[$item->id];
        $total += $item->price * $quantity;
        echo "<tr>
                <td>{$counter}</td>
                <td>{$item->title}</td>
                <td>{$item->author}</td>
                <td>{$item->pubyear}</td>
                <td>{$item->price}</td>
                <td>{$quantity}</td>
                <td><a href='remove_item_from_basket?id={$item->id}'>Удалить</a></td>
              </tr>";
        $counter++;
    }
} catch (Exception $e) {
    echo "Ошибка при получении корзины: " . $e->getMessage();
}

echo "</table>";
echo "<p>Всего товаров в корзине на сумму: {$total} руб.</p>";

echo "<div style='text-align:center'>
        <input type='button' value='Оформить заказ!' onclick=\"location.href='/create_order'\" />
      </div>";

require_once 'app/__footer.php';
?>
