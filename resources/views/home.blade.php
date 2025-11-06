@extends('layouts.app')

@section('title', 'Home - BoboPod')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-extrabold mb-4">Selamat Datang di BoboPod</h1>
            <p class="text-xl mb-8">Pengalaman menginap modern dengan teknologi pod terkini</p>
            <div class="flex justify-center space-x-4">
                <span class="bg-white/20 px-6 py-2 rounded-full text-sm">✓ WiFi Super Cepat</span>
                <span class="bg-white/20 px-6 py-2 rounded-full text-sm">✓ Smart Control</span>
                <span class="bg-white/20 px-6 py-2 rounded-full text-sm">✓ AC & Soundproof</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow-md sticky top-16 z-40" x-data="{ showFilter: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <button @click="showFilter = !showFilter" class="w-full md:hidden bg-indigo-600 text-white px-4 py-2 rounded-lg mb-4">
            <span x-show="!showFilter">Tampilkan Filter</span>
            <span x-show="showFilter">Sembunyikan Filter</span>
        </button>
        
        <form method="GET" action="{{ route('home') }}" class="md:flex items-end space-y-4 md:space-y-0 md:space-x-4" x-show="showFilter" x-transition>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Room</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Tipe</option>
                    <option value="Single" {{ request('type') == 'Single' ? 'selected' : '' }}>Single Pod</option>
                    <option value="Double" {{ request('type') == 'Double' ? 'selected' : '' }}>Double Pod</option>
                    <option value="Suite" {{ request('type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                </select>
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Maksimal</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                       placeholder="Contoh: 300000" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Filter
                </button>
            </div>
            
            <div>
                <a href="{{ route('home') }}" class="w-full md:w-auto block text-center bg-gray-200 text-gray-700 px-8 py-2 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Rooms Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Pilih Room Favorit Anda</h2>
    
    @if($rooms->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($rooms as $room)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
            <div class="relative h-64 overflow-hidden">
                <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                <div class="absolute top-4 right-4 bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $room->type }}
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $room->name }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $room->description }}</p>
                
                <div class="flex items-center justify-between mb-4">
                    <div class="text-gray-600 text-sm">
                        <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $room->capacity }} Orang
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                        <span class="text-gray-500 text-sm">/malam</span>
                    </div>
                    <a href="{{ route('room.show', $room->id) }}" 
                       class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-4 text-xl font-medium text-gray-900">Tidak ada room tersedia</h3>
        <p class="mt-2 text-gray-500">Coba ubah filter pencarian Anda</p>
    </div>
    @endif
</div>

<!-- Features Section -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Mengapa Pilih BoboPod?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Aman & Nyaman</h3>
                <p class="text-gray-600 text-sm">Keamanan 24/7 dengan sistem smart lock</p>
            </div>
            
            <div class="text-center">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Teknologi Modern</h3>
                <p class="text-gray-600 text-sm">Smart control panel di setiap pod</p>
            </div>
            
            <div class="text-center">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600 text-sm">Mulai dari Rp 150.000/malam</p>
            </div>
            
            <div class="text-center">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">Lokasi Strategis</h3>
                <p class="text-gray-600 text-sm">Dekat dengan pusat kota dan transportasi</p>
            </div>
        </div>
    </div>
</div>
@endsection