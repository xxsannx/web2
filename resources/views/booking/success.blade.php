@extends('layouts.app')

@section('title', 'Booking Berhasil - Pineus Tilu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold shadow-lg">
                        ✓
                    </div>
                    <div class="w-24 h-1 bg-green-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold shadow-lg">
                        ✓
                    </div>
                    <div class="w-24 h-1 bg-green-500"></div>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold shadow-lg">
                        ✓
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm font-medium">
                <span class="text-green-600">Pilih Spot</span>
                <span class="text-green-600">Verifikasi</span>
                <span class="text-green-600">Selesai</span>
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
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Berhasil! 🎉</h1>
                <p class="text-gray-600">Terima kasih telah memesan spot camping di Pineus Tilu</p>
            </div>

            <!-- Booking Details -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl p-6 mb-6 shadow-lg">
                <div class="text-center mb-4">
                    <p class="text-sm opacity-90 mb-1">Booking ID</p>
                    <p class="text-3xl font-bold tracking-wider">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                        <p class="text-xs opacity-90 mb-1">📅 Check-in</p>
                        <p class="font-semibold">{{ $booking->check_in->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                        <p class="text-xs opacity-90 mb-1">📅 Check-out</p>
                        <p class="font-semibold">{{ $booking->check_out->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Spot Info -->
            <div class="border-2 border-green-200 rounded-xl p-6 mb-6 bg-green-50">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                    </svg>
                    Detail Spot Camping
                </h3>
                
                <div class="flex items-start space-x-4">
                    <img src="{{ $booking->room->image }}" 
                         alt="{{ $booking->room->name }}" 
                         class="w-24 h-24 rounded-lg object-cover shadow-md">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $booking->room->name }}</h4>
                        <p class="text-sm text-gray-600 mb-2 bg-green-200 text-green-800 px-2 py-1 rounded-full inline-block">{{ $booking->room->type }}</p>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Kapasitas: {{ $booking->room->capacity }} Orang
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $booking->room->name }}</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($booking->room->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Durasi Camping</span>
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
                        <h4 class="font-semibold text-blue-900 mb-2">📋 Informasi Penting untuk Camping</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• <strong>Check-in:</strong> 14:00 WIB (setelah registrasi di pos utama)</li>
                            <li>• <strong>Check-out:</strong> 12:00 WIB (sebelum pengecekan tenda)</li>
                            <li>• <strong>Dokumen:</strong> Bawa KTP/ID card asli saat check-in</li>
                            <li>• <strong>Konfirmasi:</strong> Detail booking dikirim ke email Anda</li>
                            <li>• <strong>Kontak:</strong> Hubungi 0812-3456-7890 untuk bantuan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Camping Tips -->
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-green-900 mb-2">🏕️ Tips Camping Seru</h4>
                        <ul class="text-sm text-green-800 space-y-1">
                            <li>• Bawa pakaian hangat dan jaket untuk malam hari</li>
                            <li>• Siapkan senter/headlamp untuk aktivitas malam</li>
                            <li>• Bawa power bank untuk kebutuhan charging</li>
                            <li>• Patuhi peraturan area api unggun</li>
                            <li>• Jaga kebersihan lingkungan camping</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('booking.myBookings') }}" 
                   class="bg-green-600 text-white text-center py-3 rounded-xl font-semibold hover:bg-green-700 transition shadow-lg flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Lihat Semua Booking</span>
                </a>
                <a href="{{ route('home') }}" 
                   class="bg-white text-green-600 border-2 border-green-600 text-center py-3 rounded-xl font-semibold hover:bg-green-50 transition shadow-lg flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Home</span>
                </a>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="text-center mt-8 bg-white rounded-xl p-6 shadow-lg">
            <p class="text-gray-600 text-lg">
                Terima kasih telah mempercayai Pineus Tilu untuk petualangan camping Anda! 
            </p>
            <p class="text-green-600 font-semibold mt-2">
                Selamat menikmati alam dan sampai jumpa di petualangan berikutnya! 🌲✨
            </p>
        </div>
    </div>
</div>
@endsection