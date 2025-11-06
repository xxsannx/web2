@extends('layouts.app')

@section('title', $room->name . ' - BoboPod')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">
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
        <div>
            <div class="rounded-2xl overflow-hidden shadow-2xl">
                <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-96 object-cover">
            </div>
            
            <!-- Badge -->
            <div class="mt-4 flex space-x-2">
                <span class="bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $room->type }}
                </span>
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                    @if($room->available)
                        ✓ Tersedia
                    @else
                        ✗ Tidak Tersedia
                    @endif
                </span>
            </div>
        </div>

        <!-- Detail Section -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $room->name }}</h1>
            
            <div class="flex items-center space-x-4 mb-6">
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $room->capacity }} Orang</span>
                </div>
            </div>

            <div class="bg-indigo-50 p-6 rounded-xl mb-6">
                <div class="text-3xl font-bold text-indigo-600 mb-1">
                    Rp {{ number_format($room->price, 0, ',', '.') }}
                </div>
                <div class="text-gray-600">per malam</div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $room->description }}</p>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Fasilitas</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        WiFi Super Cepat
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        AC
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Smart Lighting
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        USB Charging
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Soundproof
                    </div>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Smart Lock
                    </div>
                </div>
            </div>

            @if($room->available)
            <a href="{{ route('booking.create', $room->id) }}" 
               class="block w-full bg-indigo-600 text-white text-center py-4 rounded-xl text-lg font-semibold hover:bg-indigo-700 transition duration-150 shadow-lg hover:shadow-xl">
                Booking Sekarang
            </a>
            @else
            <button disabled 
                    class="block w-full bg-gray-400 text-white text-center py-4 rounded-xl text-lg font-semibold cursor-not-allowed">
                Tidak Tersedia
            </button>
            @endif

            <p class="text-center text-gray-500 text-sm mt-4">
                ✓ Pembatalan gratis dalam 24 jam
            </p>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-16 bg-gray-50 p-8 rounded-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Kebijakan & Informasi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Check-in</h3>
                <p class="text-gray-600">14:00 WIB</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Check-out</h3>
                <p class="text-gray-600">12:00 WIB</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Pembatalan</h3>
                <p class="text-gray-600">Gratis dalam 24 jam</p>
            </div>
        </div>
    </div>
</div>
@endsection