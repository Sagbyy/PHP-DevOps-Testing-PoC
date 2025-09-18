<?php

use App\Invoice;
use App\InvoiceLine;
use App\Article;
use App\Services\PaypalService;

$article_one = new Article("Le Saint Coran", "Le Saint Coran description", 15.99);
$article_two = new Article("Les 30 Hadith", "Les 30 hadith description", 9.99);

$article_three = new Article("L'Exegese", "L'Exegese description", 35.99);

$invoice_line_one = new InvoiceLine($article_one, 5);
$invoice_line_two = new InvoiceLine($article_two, 1);
$invoice_line_three = new InvoiceLine($article_three, 13);

it("add invoice line", function() use($invoice_line_one, $invoice_line_two, $invoice_line_three) {
    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line($invoice_line_one);

    expect($invoice->get_invoice_lines())->toHaveCount(1);

    $invoice->add_invoice_line($invoice_line_two);
    $invoice->add_invoice_line($invoice_line_three);

    expect($invoice->get_invoice_lines())->toHaveCount(3);
});

it("send invoice", function() use($invoice_line_one) {
    $paypal_service = Mockery::mock(PaypalService::class);
    $paypal_service->shouldReceive('send_payment')->andReturn(true);

    $invoice = new Invoice($paypal_service);
    $invoice->add_invoice_line($invoice_line_one);

    expect($invoice->send_invoice("salah@contact.com"))->toBeTruthy();
});

it('check the subtotal excluding taxes', function () use($article_one, $invoice_line_one, $invoice_line_two, $invoice_line_three) {
    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line($invoice_line_one);

    expect($invoice->total_ht())->toEqual(expected: 79.95);

    $invoice->add_invoice_line($invoice_line_two);
    $invoice->add_invoice_line($invoice_line_three);

    expect($invoice->total_ht())->toEqual(557.81);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 0));

    expect($invoice->total_ht())->toEqual(0.0);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 159845612));

    expect($invoice->total_ht())->toEqual(2555931335.88);
});

it('check the vat amount', function () use($article_one, $invoice_line_one, $invoice_line_two, $invoice_line_three) {
    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line($invoice_line_one);

    expect($invoice->total_vat())->toEqual(expected: 15.99);

    $invoice->add_invoice_line($invoice_line_two);
    $invoice->add_invoice_line($invoice_line_three);

    expect($invoice->total_vat())->toEqual(111.56);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 0));

    expect($invoice->total_vat())->toEqual(0.0);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 159845612));

    expect($invoice->total_vat())->toEqual(511186267.18);
});

it('check the total TTC', function () use($article_one, $invoice_line_one, $invoice_line_two, $invoice_line_three) {
    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line($invoice_line_one);

    expect($invoice->total_ttc())->toEqual(expected: 95.94);

    $invoice->add_invoice_line($invoice_line_two);
    $invoice->add_invoice_line($invoice_line_three);

    expect($invoice->total_ttc())->toEqual(669.37);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 0));

    expect($invoice->total_ttc())->toEqual(0.0);

    $invoice = new Invoice(new PaypalService());
    $invoice->add_invoice_line(new InvoiceLine($article_one, 159845612));

    expect($invoice->total_ttc())->toEqual(3067117603.06);
});
