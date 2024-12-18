<?php
require_once 'core/init.php';
require_once 'app/__header.php';

echo "<h1>Каталог товаров</h1>";
echo "<p class='admin'><a href='admin'>админка</a></p>";
echo "<p>Товаров в <a href='basket'>корзине</a>: </p>";
echo "<table>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Год издания</th>
            <th>Цена, руб.</th>
            <th>В корзину</th>
        </tr>";

try {
    $items = Eshop::getItemsFromCatalog();
    foreach ($items as $item) {
        echo "<tr>
                <td>{$item->title}</td>
                <td>{$item->author}</td>
                <td>{$item->pubyear}</td>
                <td>{$item->price}</td>
                <td><a href='add_item_to_basket?id={$item->id}'>Добавить в корзину</a></td>
              </tr>";
    }
} catch (Exception $e) {
    echo "Ошибка при получении каталога: " . $e->getMessage();
}

echo "</table>";

require_once 'app/__footer.php';
?>
