<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($roomId)
    {
        $room = Room::findOrFail($roomId);
        return view('booking.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($request->room_id);
        
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $duration = $checkIn->diffInDays($checkOut);
        $totalPrice = $room->price * $duration;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'duration' => $duration,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // Generate OTP
        $otp = $booking->generateOTP();

        return redirect()->route('booking.confirm', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Kode OTP: ' . $otp);
    }

    public function confirm($id)
    {
        $booking = Booking::with(['room', 'user'])->findOrFail($id);
        
        // Pastikan user yang login adalah pemilik booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('booking.confirm', compact('booking'));
    }

    public function verifyOtp(Request $request, $id)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->verifyOTP($request->otp)) {
            return redirect()->route('booking.success', $booking->id)
                ->with('success', 'Verifikasi OTP berhasil!');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa']);
    }

    public function success($id)
    {
        $booking = Booking::with(['room', 'user'])->findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$booking->otp_verified) {
            return redirect()->route('booking.confirm', $booking->id);
        }

        return view('booking.success', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Booking::with('room')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-bookings', compact('bookings'));
    }
}