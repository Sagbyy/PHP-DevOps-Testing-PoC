<?php

namespace App;

use DateTime;

class Invoice {
    private DateTime $created_at;
    private DateTime $updated_at;
    private array $invoice_lines;

    public function __construct() {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->invoice_lines = [];
    }

    public function add_invoice_line(InvoiceLine $invoice_lines) {
        $this->invoice_lines[] = $invoice_lines;
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
}