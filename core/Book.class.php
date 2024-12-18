<?php
class Book {
    public $title;
    public $author;
    public $price;
    public $pubyear;

    public function __construct($title, $author, $price, $pubyear) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->pubyear = $pubyear;
    }
}
?>
