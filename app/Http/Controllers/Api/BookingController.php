<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id'      => 'required|exists:vehicles,id',
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:20',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $days = \Carbon\Carbon::parse($request->start_date)
                    ->diffInDays($request->end_date);
        $total = $days * $vehicle->price_per_day;

        $booking = Booking::create([
            'vehicle_id'     => $request->vehicle_id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'total_price'    => $total,
            'status'         => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking berhasil',
            'data'    => $booking,
            'wa_link' => $this->generateWALink($booking, $vehicle)
        ], 201);
    }

    private function generateWALink($booking, $vehicle)
    {
        $phone = config('app.owner_phone');
        $msg = urlencode(
            "Halo, saya {$booking->customer_name} ingin booking:\n" .
            "Kendaraan: {$vehicle->name}\n" .
            "Tanggal: {$booking->start_date} s/d {$booking->end_date}\n" .
            "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n" .
            "No HP: {$booking->customer_phone}"
        );
        return "https://wa.me/{$phone}?text={$msg}";
    }
}