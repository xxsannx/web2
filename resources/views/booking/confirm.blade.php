@extends('layouts.app')

@section('title', 'Konfirmasi Booking - BoboPod')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        ✓
                    </div>
                    <div class="w-24 h-1 bg-green-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="bg-indigo-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        2
                    </div>
                    <div class="w-24 h-1 bg-gray-300"></div>
                </div>
                <div class="flex items-center">
                    <div class="bg-gray-300 text-gray-600 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        3
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="text-green-600 font-semibold">Booking</span>
                <span class="text-indigo-600 font-semibold">Verifikasi</span>
                <span class="text-gray-500">Selesai</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Booking</h1>
                <p class="text-gray-600">Masukkan kode OTP untuk verifikasi booking Anda</p>
            </div>

            <!-- OTP Display -->
            @if(session('success') && str_contains(session('success'), 'OTP'))
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-900 mb-1">Kode OTP Anda:</h3>
                        <p class="text-3xl font-bold text-yellow-900 tracking-widest">
                            {{ $booking->otp }}
                        </p>
                        <p class="text-sm text-yellow-700 mt-2">
                            Kode akan kadaluarsa dalam 10 menit
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- OTP Form -->
            <form action="{{ route('booking.verifyOtp', $booking->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-6">
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center">
                        Masukkan 6 Digit Kode OTP
                    </label>
                    <input type="text" 
                           id="otp" 
                           name="otp" 
                           maxlength="6" 
                           pattern="[0-9]{6}"
                           required
                           class="w-full px-4 py-4 text-center text-2xl font-bold tracking-widest border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="000000">
                    <p class="text-sm text-gray-500 text-center mt-2">
                        Masukkan kode OTP yang ditampilkan di atas
                    </p>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-4 rounded-xl text-lg font-semibold hover:bg-indigo-700 transition duration-150 shadow-lg hover:shadow-xl">
                    Verifikasi OTP
                </button>
            </form>

            <!-- Booking Summary -->
            <div class="border-t-2 border-gray-200 pt-6">
                <h3 class="font-bold text-gray-900 mb-4 text-center">Ringkasan Booking</h3>
                
                <div class="bg-gray-50 rounded-xl p-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Booking ID:</span>
                        <span class="font-semibold text-gray-900">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Room:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->room->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Check-in:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->check_in->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Check-out:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->check_out->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Durasi:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->duration }} malam</span>
                    </div>
                    <div class="border-t border-gray-300 pt-3 mt-3">
                        <div class="flex justify-between">
                            <span class="font-bold text-gray-900">Total Pembayaran:</span>
                            <span class="font-bold text-2xl text-indigo-600">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timer Warning -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    ⏱️ Pastikan memasukkan OTP sebelum waktu habis
                </p>
            </div>
        </div>
    </div>
</div>
@endsection