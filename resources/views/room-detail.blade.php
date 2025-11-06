@extends('layouts.app')

@section('title', $room->name . ' - Pineus Tilu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 md:ml-2">{{ $room->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Image Section -->
        <div class="space-y-6">
            <div class="rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-96 object-cover hover:scale-105 transition duration-500">
            </div>
            
            <!-- Badges -->
            <div class="flex flex-wrap gap-3">
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold border border-green-200">
                    🏕️ {{ $room->type }} Camping
                </span>
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold border border-green-200">
                    @if($room->available)
                        ✅ Tersedia
                    @else
                        ❌ Tidak Tersedia
                    @endif
                </span>
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold border border-green-200">
                    👥 {{ $room->capacity }} Orang
                </span>
            </div>
        </div>

        <!-- Detail Section -->
        <div class="space-y-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $room->name }}</h1>
                
                <div class="flex items-center space-x-6 text-gray-600 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Kapasitas: {{ $room->capacity }} Orang</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>1 Malam Minimal</span>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-xl shadow-lg mb-6">
                    <div class="text-3xl font-bold mb-1">
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                    </div>
                    <div class="text-green-100">per malam</div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Deskripsi Spot
                </h2>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $room->description }}</p>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Fasilitas Camping
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Tenda Nyaman
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Sleeping Bag
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Area Api Unggun
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Toilet Umum
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Air Bersih
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Parkir Kendaraan
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        P3K Standar
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Security 24 Jam
                    </div>
                </div>
            </div>

            @if($room->available)
            <a href="{{ route('booking.create', $room->id) }}" 
               class="block w-full bg-green-600 text-white text-center py-4 rounded-xl text-lg font-semibold hover:bg-green-700 transition duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                🏕️ Booking Spot Ini
            </a>
            @else
            <button disabled 
                    class="block w-full bg-gray-400 text-white text-center py-4 rounded-xl text-lg font-semibold cursor-not-allowed shadow-lg">
                ❌ Spot Tidak Tersedia
            </button>
            @endif

            <p class="text-center text-gray-500 text-sm">
                ✅ Pembatalan gratis dalam 24 jam • ✅ Konfirmasi instan
            </p>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-16 bg-gradient-to-r from-green-50 to-emerald-50 p-8 rounded-2xl border border-green-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Camping
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">⏰ Check-in</h3>
                    <p class="text-gray-600">14:00 WIB</p>
                    <p class="text-sm text-gray-500">Setelah registrasi di pos utama</p>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">⏰ Check-out</h3>
                    <p class="text-gray-600">12:00 WIB</p>
                    <p class="text-sm text-gray-500">Sebelum pengecekan tenda</p>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">📝 Kebijakan</h3>
                    <p class="text-gray-600">Pembatalan Gratis</p>
                    <p class="text-sm text-gray-500">Dalam 24 jam pertama</p>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="font-semibold text-gray-900 mb-3">📋 Tips Camping di Pineus Tilu:</h3>
            <ul class="text-gray-600 space-y-2">
                <li>• Bawa pakaian hangat untuk malam hari</li>
                <li>• Siapkan senter/headlamp untuk aktivitas malam</li>
                <li>• Bawa power bank untuk kebutuhan charging</li>
                <li>• Patuhi peraturan area api unggun</li>
                <li>• Jaga kebersihan lingkungan camping</li>
            </ul>
        </div>
    </div>
</div>
@endsection