@extends('layouts.app')

@section('title', 'Booking Berhasil - BoboPod')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12">
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
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        ✓
                    </div>
                    <div class="w-24 h-1 bg-green-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold">
                        ✓
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="text-green-600 font-semibold">Booking</span>
                <span class="text-green-600 font-semibold">Verifikasi</span>
                <span class="text-green-600 font-semibold">Selesai</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Berhasil!</h1>
                <p class="text-gray-600">Terima kasih telah memesan di BoboPod</p>
            </div>

            <!-- Booking Details -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl p-6 mb-6">
                <div class="text-center mb-4">
                    <p class="text-sm opacity-90 mb-1">Booking ID</p>
                    <p class="text-3xl font-bold tracking-wider">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/20 rounded-lg p-3">
                        <p class="text-xs opacity-90 mb-1">Check-in</p>
                        <p class="font-semibold">{{ $booking->check_in->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white/20 rounded-lg p-3">
                        <p class="text-xs opacity-90 mb-1">Check-out</p>
                        <p class="font-semibold">{{ $booking->check_out->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Room Info -->
            <div class="border-2 border-gray-200 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Detail Room</h3>
                
                <div class="flex items-start space-x-4">
                    <img src="{{ $booking->room->image }}" 
                         alt="{{ $booking->room->name }}" 
                         class="w-24 h-24 rounded-lg object-cover">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $booking->room->name }}</h4>
                        <p class="text-sm text-gray-600 mb-2">{{ $booking->room->type }}</p>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $booking->room->capacity }} Orang
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $booking->room->name }}</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($booking->room->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Durasi</span>
                        <span class="font-semibold text-gray-900">{{ $booking->duration }} malam</span>
                    </div>
                    <div class="border-t-2 border-gray-200 pt-3 mt-3">
                        <div class="flex justify-between">
                            <span class="font-bold text-gray-900 text-lg">Total Dibayar</span>
                            <span class="font-bold text-2xl text-green-600">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Info -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-1">Informasi Penting</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Check-in: 14:00 WIB</li>
                            <li>• Check-out: 12:00 WIB</li>
                            <li>• Bawa ID Card/KTP saat check-in</li>
                            <li>• Konfirmasi booking dikirim ke email Anda</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('booking.myBookings') }}" 
                   class="bg-gray-200 text-gray-700 text-center py-3 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Lihat Semua Booking
                </a>
                <a href="{{ route('home') }}" 
                   class="bg-indigo-600 text-white text-center py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                    Kembali ke Home
                </a>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="text-center mt-8">
            <p class="text-gray-600 text-sm">
                Terima kasih telah memilih BoboPod. Sampai jumpa! 🎉
            </p>
        </div>
    </div>
</div>
@endsection