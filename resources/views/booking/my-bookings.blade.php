@extends('layouts.app')

@section('title', 'My Bookings - Pineus Tilu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Riwayat Booking Saya
        </h1>
        <p class="text-gray-600">Kelola dan pantau semua booking camping Anda di satu tempat</p>
    </div>

    @if($bookings->count() > 0)
    <div class="grid grid-cols-1 gap-6">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
            <div class="md:flex">
                <!-- Image -->
                <div class="md:w-1/3">
                    <img src="{{ $booking->room->image }}" 
                         alt="{{ $booking->room->name }}" 
                         class="w-full h-64 md:h-full object-cover">
                </div>

                <!-- Content -->
                <div class="md:w-2/3 p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-900">{{ $booking->room->name }}</h3>
                                @if($booking->status == 'confirmed')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold border border-green-200">
                                    ✅ Dikonfirmasi
                                </span>
                                @elseif($booking->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold border border-yellow-200">
                                    ⏳ Menunggu Verifikasi
                                </span>
                                @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold border border-red-200">
                                    ❌ Dibatalkan
                                </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">
                                <strong>Booking ID:</strong> #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">📅 Check-in</p>
                            <p class="font-semibold text-gray-900">{{ $booking->check_in->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">📅 Check-out</p>
                            <p class="font-semibold text-gray-900">{{ $booking->check_out->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">⏱️ Durasi</p>
                            <p class="font-semibold text-gray-900">{{ $booking->duration }} malam</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">📝 Dipesan</p>
                            <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Spot Type & Capacity -->
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold border border-green-200">
                            🏕️ {{ $booking->room->type }}
                        </span>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Kapasitas: {{ $booking->room->capacity }} Orang
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($booking->status == 'confirmed')
                    <div class="flex space-x-2">
                        <a href="{{ route('booking.success', $booking->id) }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-lg flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Lihat Detail</span>
                        </a>
                    </div>
                    @elseif($booking->status == 'pending')
                    <div class="flex space-x-2">
                        <a href="{{ route('booking.confirm', $booking->id) }}" 
                           class="bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-700 transition shadow-lg flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Verifikasi OTP</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Booking Camping</h3>
        <p class="text-gray-600 mb-6">Anda belum memiliki riwayat booking camping di Pineus Tilu</p>
        <a href="{{ route('home') }}" 
           class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center space-x-2 mx-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Mulai Booking Sekarang</span>
        </a>
    </div>
    @endif
</div>
@endsection