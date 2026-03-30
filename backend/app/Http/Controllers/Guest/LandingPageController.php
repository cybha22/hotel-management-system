<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class LandingPageController extends Controller
{
    public function index(): JsonResponse
    {
        $setting = Setting::first();
        $roomTypes = RoomType::with('facilities')
            ->where('is_active', true)
            ->get();

        return response()->json([
            'setting' => $setting,
            'room_types' => $roomTypes,
        ]);
    }

    public function roomTypes(): JsonResponse
    {
        $roomTypes = RoomType::with('facilities')
            ->where('is_active', true)
            ->withCount(['rooms as available_rooms_count' => function ($q) {
                $q->where('status', 'available');
            }])
            ->get();

        return response()->json($roomTypes);
    }

    public function roomTypeDetail(RoomType $roomType): JsonResponse
    {
        $roomType->load('facilities');
        $availableRooms = $roomType->rooms()->where('status', 'available')->count();

        return response()->json([
            'room_type' => $roomType,
            'available_rooms' => $availableRooms,
        ]);
    }
}
