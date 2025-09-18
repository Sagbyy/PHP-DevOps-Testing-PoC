<?php

namespace App;

use Exception;

class PaypalService {
    public function send_payment(string $email_recipient, float $amount, string $message) {
        throw new Exception("Paypal network is not available");
    }
}