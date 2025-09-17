<?php 

namespace App;

use Exception;
use InvalidArgumentException;

class Article {
    private string $title;
    private string $description;
    private float $price_ht;

    public function __construct(string $title, string $description, float $price_ht) {
        if($price_ht < 0) throw new InvalidArgumentException("The price must be greather than 0");

        $this->title = $title;
        $this->description = $description;
        $this->price_ht = $price_ht;
    }

    public function get_price_ht() {
        return bcdiv($this->price_ht, '1', 2);
    }
}