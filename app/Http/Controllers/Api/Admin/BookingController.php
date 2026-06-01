<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(
            Booking::with('vehicle')->latest()->get()
        );
    }

    public function updateStatus($id, $status)
    {
        $booking = Booking::findOrFail($id);

        if (!in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            return response()->json(['message' => 'Status tidak valid'], 422);
        }

        $booking->update(['status' => $status]);
        return response()->json($booking);
    }
}