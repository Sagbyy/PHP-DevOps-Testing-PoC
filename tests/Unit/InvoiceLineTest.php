<?php

use App\InvoiceLine;
use App\Article;

$article = new Article("Le Saint Coran", "Le Saint Coran description", 15.99);

it('check the subtotal excluding taxes', function () use($article) {
    $invoice_line = new InvoiceLine($article, 5);
    expect($invoice_line->subtotal_ht())->toEqual(79.95);

    $invoice_line = new InvoiceLine($article, 1);
    expect($invoice_line->subtotal_ht())->toEqual(15.99);

    $invoice_line = new InvoiceLine($article, 0);
    expect($invoice_line->subtotal_ht())->toEqual(0.0);

    $invoice_line = new InvoiceLine($article, 159845612);
    expect($invoice_line->subtotal_ht())->toEqual(2555931335.88);
});

it('check the vat amount', function () use($article) {
    $invoice_line = new InvoiceLine($article, 5);
    expect($invoice_line->vat_amount())->toEqual(15.99);

    $invoice_line = new InvoiceLine($article, 1);
    expect($invoice_line->vat_amount())->toEqual(3.20);

    $invoice_line = new InvoiceLine($article, 0);
    expect($invoice_line->vat_amount())->toEqual(0.0);

    $invoice_line = new InvoiceLine($article, 159845612);
    expect($invoice_line->vat_amount())->toEqual(511186267.18);
});

it('check the total TTC', function () use($article) {
    $invoice_line = new InvoiceLine($article, 5);
    expect($invoice_line->subtotal_ttc())->toEqual(95.94);

    $invoice_line = new InvoiceLine($article, 1);
    expect($invoice_line->subtotal_ttc())->toEqual(19.19);

    $invoice_line = new InvoiceLine($article, 0);
    expect($invoice_line->subtotal_ttc())->toEqual(0.0);

    $invoice_line = new InvoiceLine($article, 159845612);
    expect($invoice_line->subtotal_ttc())->toEqual(3067117603.06);
});
