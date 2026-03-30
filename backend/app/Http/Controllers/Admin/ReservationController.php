<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = Reservation::with(['guest', 'room.roomType', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('check_in_date', $request->date);
        }

        $reservations = $query->latest()->paginate(10);
        return response()->json($reservations);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email',
            'guest_phone' => 'nullable|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
        ]);

        $reservation = $this->reservationService->createManualReservation($validated);

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json($reservation->load(['guest', 'room.roomType', 'payments']));
    }
}
