<?php

namespace App\Services;

use App\Models\Reservation;

class CheckInOutService
{
    public function processCheckIn(Reservation $reservation): Reservation
    {
        $reservation->update(['status' => 'checked_in']);
        $reservation->room->update(['status' => 'occupied']);

        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        return $reservation->load(['guest', 'room.roomType']);
    }

    public function processCheckOut(Reservation $reservation): Reservation
    {
        $reservation->update(['status' => 'checked_out']);
        $reservation->room->update(['status' => 'cleaning']);

        if (!\App\Models\Payment::where('reservation_id', $reservation->id)->exists()) {
            \App\Models\Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price,
                'payment_method' => 'Sistem Otomatis (Cash)',
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        return $reservation->load(['guest', 'room.roomType']);
    }
}
