<?php
class Basket {
    private static $basket = [];

    public static function init() {
        if (isset($_COOKIE['eshop'])) {
            self::read();
        } else {
            self::create();
        }
    }

    public static function add($itemId, $quantity) {
        if (isset(self::$basket[$itemId])) {
            self::$basket[$itemId] += $quantity;
        } else {
            self::$basket[$itemId] = $quantity;
        }
        self::save();
    }

    public static function remove($itemId) {
        if (isset(self::$basket[$itemId])) {
            unset(self::$basket[$itemId]);
            self::save();
        }
    }

    public static function save() {
        setcookie('eshop', json_encode(self::$basket), time() + 3600 * 24 * 30, "/");
    }

    public static function create() {
        self::$basket = ['order-id' => uniqid()];
        self::save();
    }

    public static function read() {
        self::$basket = json_decode($_COOKIE['eshop'], true);
    }

    public static function getBasket() {
        return self::$basket;
    }
}
?>
