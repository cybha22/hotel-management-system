<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;

class ReservationService
{
    public function createManualReservation(array $data): Reservation
    {
        $room = Room::with('roomType')->findOrFail($data['room_id']);
        $nights = Carbon::parse($data['check_in_date'])->diffInDays($data['check_out_date']);
        $totalPrice = $room->roomType->base_price * $nights;

        $guest = Guest::firstOrCreate(
            ['email' => $data['guest_email'] ?? null],
            [
                'name' => $data['guest_name'],
                'phone' => $data['guest_phone'] ?? null,
            ]
        );

        if (!$guest->wasRecentlyCreated) {
            $guest->update([
                'name' => $data['guest_name'],
                'phone' => $data['guest_phone'] ?? $guest->phone,
            ]);
        }

        $reservation = Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'number_of_guests' => $data['number_of_guests'],
            'status' => 'confirmed',
            'total_price' => $totalPrice,
            'special_requests' => $data['special_requests'] ?? null,
        ]);

        $room->update(['status' => 'reserved']);

        return $reservation->load(['guest', 'room.roomType']);
    }

    public function createOnlineBooking(array $data): Reservation
    {
        $roomType = RoomType::findOrFail($data['room_type_id']);
        $room = Room::where('room_type_id', $roomType->id)
            ->where('status', 'available')
            ->first();

        if (!$room) {
            throw new \Exception('Maaf, tidak ada kamar tersedia untuk tipe ini.');
        }

        $nights = Carbon::parse($data['check_in_date'])->diffInDays($data['check_out_date']);
        $totalPrice = $roomType->base_price * $nights;

        $guest = Guest::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]
        );

        $reservation = Reservation::create([
            'reservation_code' => Reservation::generateCode(),
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'number_of_guests' => $data['number_of_guests'],
            'status' => 'pending',
            'total_price' => $totalPrice,
            'special_requests' => $data['special_requests'] ?? null,
        ]);

        $room->update(['status' => 'reserved']);

        return $reservation;
    }

    public function confirmBooking(Reservation $reservation): Reservation
    {
        $reservation->update(['status' => 'confirmed']);
        return $reservation->load(['guest', 'room.roomType']);
    }

    public function rejectBooking(Reservation $reservation): Reservation
    {
        $reservation->update(['status' => 'cancelled']);
        $reservation->room->update(['status' => 'available']);
        return $reservation->load(['guest', 'room.roomType']);
    }
}
