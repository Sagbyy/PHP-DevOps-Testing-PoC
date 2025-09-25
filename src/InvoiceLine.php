<?php

namespace App;


class InvoiceLine {
    private Article $article;
    private string $quantity;
    private float $vat_rate;

    public function __construct(Article $article, string $quantity, float $vat_rate = 0.20) {
        $this->article = $article;
        $this->quantity = $quantity;
        $this->vat_rate = $vat_rate;
    }

    public function subtotal_ht() {
        return bcdiv($this->article->get_price_ht() * $this->quantity, '1', 2);
    }

    public function vat_amount() {
        return round(($this->article->get_price_ht() * $this->quantity) * $this->vat_rate, 2);
    }

    public function subtotal_ttc() {
        return $this->subtotal_ht() + $this->vat_amount();
    }

    public function get_invoice_line() {
        return [
            'article' => $this->article,
            'quantity' => $this->quantity,
            'vat_rate' => $this->vat_rate,
        ];
    }
}