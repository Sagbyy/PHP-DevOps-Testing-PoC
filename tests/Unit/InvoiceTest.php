<?php

use App\Invoice;
use App\InvoiceLine;
use App\PaypalService;
use Mockery;

$invoice_line = new InvoiceLine($article, 5);

it("add invoice line", function() use($invoice_line) {
    $invoice = new Invoice();
    $invoice->add_invoice_line($invoice_line);
    $paypal_service = Mockery::mock(PaypalService::class);
    $paypal_service->shouldReceive('send_payment');

    expect(count($invoice->get_invoice_lines()))->toEqual(1);
});