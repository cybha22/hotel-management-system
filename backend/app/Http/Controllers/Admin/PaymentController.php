<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index(): JsonResponse
    {
        $payments = Payment::with('reservation.guest')
            ->latest()
            ->paginate(10);

        return response()->json($payments);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
        ]);

        $payment = $this->paymentService->recordPayment($validated);

        return response()->json($payment, 201);
    }

    public function invoice(Payment $payment): JsonResponse
    {
        $invoiceData = $this->paymentService->getInvoiceData($payment);

        return response()->json($invoiceData);
    }
}
