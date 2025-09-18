<?php

namespace App;

use DateTime;

class Invoice {
    private DateTime $created_at;
    private DateTime $updated_at;
    private array $invoice_lines;
    private PaypalService $paypal_service;

    public function __construct(PaypalService $paypal_service) {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->invoice_lines = [];
        $this->paypal_service = $paypal_service;
    }

    public function add_invoice_line(InvoiceLine $invoice_lines) {
        $this->invoice_lines[] = $invoice_lines;
        $this->updated_at = new DateTime();
    }

    public function get_invoice_lines() {
        return $this->invoice_lines;
    }

    public function total_ht() {
        $total = 0;

        foreach($this->invoice_lines as $invoice_line) {
            $total += $invoice_line->subtotal_ht();
        }

        return bcdiv($total, '1', 2);
    }

    public function total_vat() {
        $total = 0;

        foreach($this->invoice_lines as $invoice_line) {
            $total += $invoice_line->vat_amount();
        }

        return round($total, 2);
    }

    public function total_ttc() {
        $total = 0;

        foreach($this->invoice_lines as $invoice_line) {
            $total += $invoice_line->subtotal_ttc();
        }

        return bcdiv($total, '1', 2);
    }

    public function send_invoice(string $email_recipient) {
        $message = "Please pay this amount of " . $this->total_ttc() . "€";
        print $message;
        return $this->paypal_service->send_payment($email_recipient, $this->total_ttc(), $message);
    }
}