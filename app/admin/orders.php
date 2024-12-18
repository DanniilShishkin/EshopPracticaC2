<?php
require_once '../core/init.php';
require_once '../app/__header.php';

echo "<h1>Поступившие заказы:</h1>";
echo "<a href='/admin'>Назад в админку</a>";
echo "<hr>";

try {
    $orders = Eshop::getOrders();
    foreach ($orders as $order) {
        echo "<h2>Заказ номер: {$order->id}</h2>";
        echo "<p><b>Заказчик</b>: {$order->customer}</p>";
        echo "<p><b>Email</b>: {$order->email}</p>";
        echo "<p><b>Телефон</b>: {$order->phone}</p>";
        echo "<p><b>Адрес доставки</b>: {$order->address}</p>";
        echo "<p><b>Дата размещения заказа</b>: {$order->created}</p>";

        echo "<h3>Купленные товары:</h3>";
        echo "<table>
                <tr>
                    <th>N п/п</th>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Год издания</th>
                    <th>Цена, руб.</th>
                    <th>Количество</th>
                </tr>";

        $counter = 1;
        foreach ($order->items as $item) {
            echo "<tr>
                    <td>{$counter}</td>
                    <td>{$item->title}</td>
                    <td>{$item->author}</td>
                    <td>{$item->pubyear}</td>
                    <td>{$item->price}</td>
                    <td>{$item->quantity}</td>
                  </tr>";
            $counter++;
        }

        echo "</table>";
        echo "<p>Всего товаров в заказе на сумму: {$order->total} руб.</p>";
        echo "<hr>";
    }
} catch (Exception $e) {
    echo "Ошибка при получении заказов: " . $e->getMessage();
}

require_once '../app/__footer.php';
?>
