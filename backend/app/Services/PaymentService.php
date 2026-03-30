<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    public function recordPayment(array $data): Payment
    {
        $payment = Payment::create([
            'reservation_id' => $data['reservation_id'],
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return $payment->load('reservation.guest');
    }

    public function getInvoiceData(Payment $payment): Payment
    {
        return $payment->load(['reservation.guest', 'reservation.room.roomType']);
    }
}
